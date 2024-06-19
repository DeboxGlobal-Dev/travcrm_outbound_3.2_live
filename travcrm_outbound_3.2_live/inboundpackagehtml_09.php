<?php 
include "inc.php";  
	
$rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['id']).'"');  
$resultpageQuotation=mysqli_fetch_array($rsp);  

$select='*';  
$where='id='.$resultpageQuotation['queryId'].'';  
$rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
$resultpage=mysqli_fetch_array($rs); 

$totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];
$queryId = $resultpageQuotation['queryId'];
$quotationId= $resultpageQuotation['id'];

if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
	$inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
}
if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
	$exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
}
if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
	$tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
}

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
 
?>
<style>
table,thead,tbody,tr,th,td,p,div,span,ul,li,a,u,b {
  font-family: Arial !important;
}
</style>
<div style="display:none;" class="calcostsheet">
     <?php include_once("loadFITCostSheet.php"); ?>
</div>
<div>
  <table width="725" align="center" border="0" cellpadding="10" cellspacing="0" bordercolor="#000000" style=" border: 5px solid #dfdfdf;"><tr>
    <td colspan="2" align="center" valign="top"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo;?>" width="600" height="93" /></td>
  </tr> 
<tr>
	<td colspan="2" style="color:#000;font-size:20px;text-align:center;"><strong><?php echo ($quotationSubject); ?></strong></td>
</tr>  
 <tr>
		<?php 
		if($resultpageQuotation['image']!=''){
			$proposalImg = $fullurl.'dirfiles/'.$resultpageQuotation['image'];
			if(file_exists($proposalImg)==true){
				$proposalPhoto = $proposalImg;
			}else{
				$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
			}
		}else{
			$proposalPhoto = $fullurl.'images/sample-proposal.jpg';
		}
		?>
		<td colspan="2"><img src="<?php echo $proposalPhoto; ?>" width="720" height="300"/></td>
	</tr>
<tr>	
	<td colspan="2" align="center"> 
	<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
		  	<tr style="page-break-inside:avoid;height:25px;">
			<td width="20%" valign="middle" bgcolor="#F4F4F4"><strong>Year</strong></td>
			<td width="14%" valign="middle" bgcolor="#F4F4F4"><strong>Location</strong></td>
			<td width="48%" valign="middle" bgcolor="#F4F4F4"><strong>Itinerary</strong></td>
			<td width="18%" valign="middle" bgcolor="#F4F4F4"><strong>Hotel&amp;Meals</strong></td>
 			</tr>
			<?php
 
			$day=1;
			$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
			while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
				$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
				$dayId = $QueryDaysData['id']; 
				 
				// services list 
				$itiQuery1 = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType = "enroute" and startDate="'.$dayDate.'" order by srn asc,id desc';
				$itineryDay1=GetPageRecord('*','quotationItinerary',$itiQuery1);  
				while($itineryDayData1 = mysqli_fetch_array($itineryDay1)){
					if($itineryDayData1['serviceType'] == 'enroute'){  
					  $wherent='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData1['serviceId'].'"  order by id desc'; 
						$rsent=GetPageRecord('*','quotationEnrouteMaster',$wherent);  
						if(mysqli_num_rows($rsent) > 0){
							while($enroutelisting=mysqli_fetch_array($rsent)){  
								$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id="'.$enroutelisting['enrouteId'].'"');  
								$enrouteData=mysqli_fetch_array($rsentn);    
								$enrouteName = "Enroute :".$enrouteData['enrouteName']."<br>";
								if($resultpageQuotation['languageId'] != "0"){
								 	$rs2=GetPageRecord('*','enrouteLanguageMaster','enrouteId="'.$enroutelisting['enrouteId'].'"');  
									$checkrow = mysqli_num_rows($rs2);
									$quotationotherenrouteLanData=mysqli_fetch_array($rs2);
									if($checkrow > 0){
										$enrouteDetail =  strip($quotationotherenrouteLanData['lang_0'.$resultpageQuotation['languageId']])."<br>"; 
								  } else{
										$enrouteDetail =  "<br>";
									} 
								} else {
									$enrouteDetail =  strip($enrouteData['enrouteDetail'])."<br>";
						    } 
							}  
						} 
						?>
						<tr style="page-break-inside:avoid">
						<td valign="top">
						<?php echo date('l dS F Y', strtotime($dayDate)); ?></td>
						<td valign="top"><?php echo ucfirst($enrouteData['enrouteCity']); ?></td>
						<td align="left" valign="top"><?php echo $enrouteName.$enrouteDetail; ?> </td>
						</tr>
						<?php 
					}
				}
				?>	
				<tr style="page-break-inside:avoid">
				<td valign="top">
				<?php echo date('l dS F Y', strtotime($dayDate)); ?></td>
				<td valign="top"><?php echo getDestination($QueryDaysData['cityId']); $destn = getDestination($QueryDaysData['cityId']); ?></td>
				<td align="left" valign="top"><?php
				// title and description
				if($QueryDaysData['title']!='' || $QueryDaysData['description']!=''){
					echo '<span style="text-align:justify">'.urldecode(strip($QueryDaysData['title'])).'</span><br /><span style="text-align:justify;">'.urldecode(strip($QueryDaysData['description'])).'</span><br />'; 
				}   
			
				// services list 
				$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc,id desc';
				$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
				while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
				
					if($itineryDayData['serviceType'] == 'hotel' ){ 
						$where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$itineryDayData['serviceId'].'"';   
						$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
						if(mysqli_num_rows($rs22) > 0){
								
									while($hotellisting=mysqli_fetch_array($rs22)){  
									$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
									$hotelData=mysqli_fetch_array($rs1ee);   
									//hotel details
									echo "Stay&nbsp;at&nbsp;".$hotelData['hotelName']."<br>";
									
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
							echo "Transport :".$transfergdetail['transferName']."<br>";							
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
							echo "Entrance :".$entranceData['entranceName']."<br>";
							if($resultpageQuotation['languageId'] != "0"){
						 	$rs2=GetPageRecord('*','entranceLanguageMaster','entranceId="'.$entrancelisting['entranceNameId'].'"');  
							$checkrow = mysqli_num_rows($rs2);
							$quotationotherEntranceLanData=mysqli_fetch_array($rs2);
								if($checkrow > 0){
								echo strip($quotationotherEntranceLanData['lang_0'.$resultpageQuotation['languageId']])."<br>"; 

							        } else{
									echo "<br>";
								    } } else {
									echo strip($entranceData['entranceDetail'])."<br>";
								    } 
								  
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
							echo  "Additional: ".strip($extraData['name']); 
						}
					}  
					if($itineryDayData['serviceType'] == 'activity'){ 
						$where22='quotationId="'.$QueryDaysData['quotationId'].'"  and id="'.$itineryDayData['serviceId'].'"  order by id desc';   
						$rs22=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where22);  
						if(mysqli_num_rows($rs22) > 0){   
							while($activitylisting=mysqli_fetch_array($rs22)){   
							$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id = "'.$activitylisting['otherActivityName'].'" and  status=1');  
							$quotationotherActivityData=mysqli_fetch_array($rs1);   
							echo "Activity :".$quotationotherActivityData['otherActivityName']."<br>";
							if($resultpageQuotation['languageId'] != '0'){
						 	$rs2=GetPageRecord('*','activityLanguageMaster','ActivityId="'.$activitylisting['otherActivityName'].'"'); 
							$checkrow = mysqli_num_rows($rs2);
							$quotationotherActivityLanData=mysqli_fetch_array($rs2);
						if($checkrow > 0){
						echo strip($quotationotherActivityLanData['lang_0'.$resultpageQuotation['languageId']])."<br>"; 
							        } else{
									echo "<br>";
								    } } 
								    else{
									echo strip($quotationotherActivityData['otherActivityDetail'])."<br>";
								    }
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
									$dptTime = "/@".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
								}else{
									$dptTime ='';
								}	
								if(date('H:i',strtotime($flightQuoteData['arrivalTime'])) <> '05:30'){
									$avrTime = date('Hi',strtotime($flightQuoteData['arrivalTime'])).'Hrs';
								}else{
									$avrTime ='';
								}		 
								 
								$jfrom = getDestination($flightQuoteData['departureFrom']);
								$jto= getDestination($flightQuoteData['arrivalTo']);

								echo "Flight: ".strip($flightData['flightName']).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$dptTime.$avrTime.'/'.strip($flightQuoteData['flightClass'])."  <br>";	

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
								
								if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '05:30'){
									$dptTime = "/@".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
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

								echo"Train: ".strip($trainData['trainName']).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/'.strip($trainQuoteData['trainClass']); 			   
							} 
						} 
					}
				echo "<br />";
				}	
				?></td>	
				<td valign="top">
					<?php 

				// services list
				$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
				$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
				while($itineryDayData = mysqli_fetch_array($itineryDay)){ 
				
					if($itineryDayData['serviceType'] == 'hotel' ){
							$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
							while($sorting1=mysqli_fetch_array($b1)){ 
								 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1 and id="'.$sorting1['serviceId'].'"';   
								$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
								if(mysqli_num_rows($rs22) > 0){

									while($hotellisting=mysqli_fetch_array($rs22)){  
										$hotelTypeLable ='';
										if($hotellisting['isLocalEscort']==1){
								        $hotelTypeLable .= "Local Escort,";
								    }
								    if($hotellisting['isForeignEscort']==1){
								        $hotelTypeLable .= "Foreign Escort,";
								    }
								    if($hotellisting['isGuestType']==1){
								        $hotelTypeLable .= "Guest,";
								    }
									$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
									$hotelData=mysqli_fetch_array($rs1ee);   
									//hotel details
									 
									$rs12=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"'); 
									$editresult2=mysqli_fetch_array($rs12);
									$rtype=$editresult2['name'];
									
									echo rtrim($hotelTypeLable,',')." Hotel :- ".$hotelData['hotelName']."<br>".$rtype."<br><br>";
									
									}
								}
							}
						}
			
				}	
				?></td>
				</tr>
		  	<?php $day++; } ?>
			<tr> 
			<td colspan="4" align="center">*************</td>
			 </tr>
		</table>
	</td>
</tr>


	<!-- Total Tour Cost and per person basis costs details -->
				<tr style="page-break-inside:avoid">
					<td colspan="2" align="center">
						<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
							<tr>
								<?php
								$conspan = 0;
								if($ppCostONSingleBasis>0){ $conspan=$conspan+1; }
								if($ppCostONDoubleBasis>0){ $conspan=$conspan+1; }
								if($pcCostOnExtraBedABasis>0){ $conspan=$conspan+1; }
								if($pcCostOnExtraBedCBasis>0){ $conspan=$conspan+1; }
								$colsWidth = 80/$conspan;
								?>
								<td width="20%" align="right" rowspan="2" bgcolor="#F4F4F4" valign="middle"><strong>Total Cost(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></td>
								<?php if($conspan>0){ ?>
								<td width="80%" colspan="<?php echo $conspan; ?>" align="center" valign="middle" bgcolor="#F4F4F4"><strong>Per Person Cost(In&nbsp;<?php echo getCurrencyName($newCurr); ?>)</strong></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($ppCostONSingleBasis>0){ ?>
								<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#F4F4F4"><div align="right"><strong>Single Basis</strong></div></td>
								<?php } if($ppCostONDoubleBasis>0){ ?>
								<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#F4F4F4"><div align="right"><strong>Double Basis</strong></div></td>
								<?php } if($pcCostOnExtraBedABasis>0){ ?>
								<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#F4F4F4"><div align="right"><strong>ExtraBed(Adult) Basis</strong></div></td>
								<?php } if($pcCostOnExtraBedCBasis>0){ ?>
								<td width="<?php echo $colsWidth; ?>%" valign="middle" bgcolor="#F4F4F4"><div align="right"><strong>ExtraBed(child) Basis</strong></div></td>
								<?php } ?>
							</tr>
							
							<tr>
								<td valign="middle"><div align="right">
									<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$proposalCost)); ?>
								</div></td>
								<?php if($ppCostONSingleBasis>0){ ?>
								<td valign="middle">
									<div align="right">
										<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONSingleBasis)); ?>
									</div>
								</td>
								<?php } if($ppCostONDoubleBasis>0){ ?>
								<td valign="middle">
									<div align="right">
										<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$ppCostONDoubleBasis)); ?>
									</div>
								</td>
								<?php } if($pcCostOnExtraBedABasis>0){ ?>
								<td valign="middle">
									<div align="right">
										<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedABasis)); ?>
									</div>
								</td>
								<?php } if($pcCostOnExtraBedCBasis>0){ ?>
								<td valign="middle">
									<div align="right">
										<?php echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$pcCostOnExtraBedCBasis)); ?>
									</div>
								</td>
								<?php } ?>
							</tr>
						</table>
						
					</td>
				</tr>

	
<tr style="font-size:12px">
  <td colspan="2" align="left" valign="top"><strong style="font-size:15px;">Inclusion</strong><br />
  <?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($inclusion)))); ?></td>
</tr>
<tr style="font-size:12px">
  <td colspan="2" align="left" valign="top"><strong style="font-size:15px;">Exclusion</strong><br />
 <?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($exclusion)))); ?></td>
</tr>
 
<tr>
	<td colspan="2" align="center" valign="top">
					<div style="font-size:12px;">
					<a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666;">Generated by TravCRM</a>					</div>				</td>
</tr>
</table>
</div>
