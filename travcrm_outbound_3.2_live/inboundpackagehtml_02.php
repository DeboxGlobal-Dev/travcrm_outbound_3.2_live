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

?> 
<!DOCTYPE html>
<html>
<body > 
<div style="display:none;display:none;visibility: hidden;height: 0;width: 0;position: fixed;left: 0;top: 0;" class="calcostsheet">
<?php  
if($resultpage['travelType']==2){
	include_once("loadFITCostSheet_domestic.php"); 
}else{
	include_once("loadFITCostSheet.php"); 
}
?>
</div>
<style type="text/css">
div,p,span,table,td,tr,li,ul,body{
font-family: 'Open Sans', sans-serif;
}
div,p,span,li,ul,body{
font-size: 12px;
color: #323030; 
}
</style>
<div class="main-container" style="font-family: 'Open Sans', sans-serif; font-weight: 300;border: 0px solid #ffffff;width: 100%;"><?php
	// proposal header image ===========
	$rs03='';
	$rs03=GetPageRecord('*','imageGallery',' parentId in ( select id from proposalSettingMaster where proposalNum="2" ) and galleryType="proposalheader" and deleteStatus=0 and fileId in ( select id from documentFiles where fileDimension="790x100" order by id desc) order by id desc');
	$resListing3=mysqli_fetch_array($rs03);
	$proposalPhoto3 = geDocFileSrc($resListing3['fileId']);
    if($resListing3['fileId']!='' && file_exists($proposalPhoto3)==true){ ?> 	
    	<table  width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td align="center" valign="top">
						<img src="<?php echo $fullurl.str_replace(' ', '%20',$proposalPhoto3); ?>" width="620" height="80" >
					</td>
				</tr>
			</tbody>
		</table>
		<?php
    }
	?>
	<table width="100%" border="0" cellpadding="10" cellspacing="0" >
		<tr><td align="center" colspan="2"><h3>Brief Proposal</h3></td></tr>
		<tr>
			<td width="50%" rowspan="3" valign="middle" >
				<strong style="padding: 20px 0;font-size:16px;"><?php echo strip($quotationSubject); ?></strong> 
			</td>
			<td width="50%" align="left" style="color:#000; border-left:1px solid #ddd;"><strong style="display:inline-block;">Printed On: <?php echo date('d/m/Y H:i:s a');?></strong></td>
		</tr>
		<tr>
			<td width="50%" align="left"  style="color:#000;border-left:1px solid #ddd;"><strong style="display:inline-block;">Enq. No: <?php echo $quotPreviewId; ?></strong></td>
		</tr>
		<tr>
			<td width="50%" align="left"  style="color:#000;border-left:1px solid #ddd;"><strong style="display:inline-block;">No of Pax: <?php echo $totalPax; ?></strong></td>
		</tr>
	</table> 
	<?php		
	//------------------------------
		$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
		$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
		$dayId = $QueryDaysData['id']; 
		$cityId = $QueryDaysData['cityId']; 
		?>
		<div class="dayTitle" style="line-height: 25px;font-size: 15px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('l',strtotime($dayDate));?> <?php echo date('j M Y',strtotime($dayDate));?></div>
		<table width="100%" border="0" cellpadding="10" cellspacing="0" >
			<tr>
			<td width="2%">&nbsp;</td>	
			<td width="98%">
				<span class="serviceDesc" style="text-align: left;page-break-inside: auto;font-size: 14px;line-height: 18px;"><?php 
					if(strlen($QueryDaysData['title'])>1) { 
						echo "<strong>".urldecode(strip($QueryDaysData['title']))."</strong><br>"; 
					
					} 
					 
					$html = trim(urldecode(strip($QueryDaysData['description'])));
					if($html!=''){
						$html = str_replace('<ul>','<p>', $html);
						$html = str_replace('</ul>','</p>', $html);
						$html = str_replace('<li>','<p>', $html);
						$html = str_replace('</li>','</p>', $html);
						$html = str_replace('<p>&nbsp;</p>', '', $html);
						$html = str_replace('<p>', '<span>', $html);
						echo $html = str_replace('</p>', '</span>', $html);
					}
					// services list
					$cnt1 = 1;
					$itiQuery1 = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceId not in ( select id from quotationHotelMaster where quotationId="'.$quotationId.'" and isHotelSupplement!=1 )  and startDate="'.$dayDate.'"  and dayId="'.$dayId.'" order by srn asc';
					$itineryDay1=GetPageRecord('*','quotationItinerary',$itiQuery1);  
					$totolDays1 = mysqli_num_rows($itineryDay1);
					while($sorting3 = mysqli_fetch_array($itineryDay1)){ 	  
						if($sorting3['serviceType'] == 'hotel' ){
							$where22='quotationId="'.$quotationId.'" and  id="'.$sorting3['serviceId'].'"';   
							$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
							if(mysqli_num_rows($rs22) > 0){ 
								$hotelQouteData=mysqli_fetch_array($rs22); 								
								$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');  
								$hotelData=mysqli_fetch_array($rs1ee); 
								echo "<p>".$cnt1.") <strong>Hotel:</strong> Stay at ".stripslashes($hotelData['hotelName'])."</p>";		
								// if($cnt1 < $totolDays1){ echo "<br />"; }  				
							}	 
						}	
						if($sorting3['serviceType'] == 'flight' ){
							$where22flt1='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"'; 
							$rs22flt1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22flt1);
							if(mysqli_num_rows($rs22flt1) > 0){ 
								$flightQuoteData = mysqli_fetch_array($rs22flt1);
								
								$rs1=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData['flightId'].'"');  
								$flightData=mysqli_fetch_array($rs1);
								
								if(date('H:i',strtotime($flightQuoteData['departureTime'])) <> '05:30'){
									$departureTime = " at ".date('Hi',strtotime($flightQuoteData['departureTime']))."/";
								}else{
									$departureTime ='';
								}	
								if(date('H:i',strtotime($flightQuoteData['arrivalTime'])) <> '05:30'){
									$arrivalTime = date('Hi',strtotime($flightQuoteData['arrivalTime']));
								}else{
									$arrivalTime ='';
								}	 
								
								$jfrom = getDestination($flightQuoteData['departureFrom']);
								$jto= getDestination($flightQuoteData['arrivalTo']); 

								echo "<p>".$cnt1.") <strong>Flight:</strong> ".strip($flightData['flightName']).' from '.$jfrom.' to '.$jto." by ".strip($flightQuoteData['flightNumber']).' '.$departureTime.$arrivalTime.'/ '.str_replace('_',' ',$flightQuoteData['flightClass'])."</p>"; 

								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							} 
						}	
						if($sorting3['serviceType'] == 'train' ){ 
							
								$where22='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"'; 
								$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
								if(mysqli_num_rows($rs22) > 0){ 
									$trainQuoteData=mysqli_fetch_array($rs22);

									$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
									$trainData=mysqli_fetch_array($rs1);  

									$journeyType="";
									$jfrom = getDestination($trainQuoteData['departureFrom']);
									$jto= getDestination($trainQuoteData['arrivalTo']);

									if(date('H:i',strtotime($trainQuoteData['departureTime'])) <> '05:30'){
									$departureTimet = " at ".date('Hi',strtotime($trainQuoteData['departureTime']))."/";
									}else{
									$departureTimet ='';
									}	
									if(date('H:i',strtotime($trainQuoteData['arrivalTime'])) <> '05:30'){
									$arrivalTimet = date('Hi',strtotime($trainQuoteData['arrivalTime']));
									}else{
									$arrivalTimet = '';
									}


								if($trainQuoteData['journeyType']=='overnight_journey'){ $journeyType="(Overnight)"; }
								else{ $journeyType="(Day)"; }

									echo "<p>".$cnt1.") <strong>Train:</strong> ".strip($trainData['trainName']).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$departureTimet.$arrivalTimet.'/ '.str_replace('_',' ',$trainQuoteData['trainClass'])."</p>"; 

									// if($cnt1 < $totolDays1){ echo "<br />"; }  
								} 	
						}	
						if($sorting3['serviceType'] == 'transfer' || $sorting3['serviceType'] == 'transportation'){  
						
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*','quotationTransferMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$transferQuotData=mysqli_fetch_array($b); 
								$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');  
								$transferData=mysqli_fetch_array($rsentn); 
								echo "<p>".$cnt1.") <strong>Transport:</strong> ".strip($transferData['transferName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; }  
								 
								//ticketAdultCost
							}
						}
						if($sorting3['serviceType'] == 'entrance'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*','quotationEntranceMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$entranceQuotData=mysqli_fetch_array($b); 
								$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'id="'.$entranceQuotData['entranceNameId'].'"');  
								$entranceData=mysqli_fetch_array($rsentn); 
								echo  "<p>".$cnt1.") <strong>Entrance:</strong> ".strip($entranceData['entranceName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								//ticketAdultCost
							}
						}
						if($sorting3['serviceType'] == 'ferry'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_FERRY_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$ferryQuotData=mysqli_fetch_array($b); 
								$rsentn=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$ferryQuotData['serviceid'].'"');  
								$ferryData=mysqli_fetch_array($rsentn); 
								echo  "<p>".$cnt1.") <strong>Ferry:</strong> ".strip($ferryData['name'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
							}
						}
						if($sorting3['serviceType'] == 'activity'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$activityQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id ="'.$activityQuotData['otherActivityName'].'"');  
								$activityData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Activity:</strong> ".strip($activityData['otherActivityName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								//perPaxCost
							}
						} 
						if($sorting3['serviceType'] == 'enroute'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*','quotationEnrouteMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$enrouteQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*','packageBuilderEnrouteMaster',' id ="'.$enrouteQuotData['enrouteId'].'"');  
								$enrouteData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Enroute:</strong> ".strip($enrouteData['enrouteName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								//adultCost
							}
						} 
						if($sorting3['serviceType'] == 'mealplan'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$mealplanQuotData=mysqli_fetch_array($b);
								echo  "<p>".$cnt1.") <strong>Restaurant :</strong> ".strip($mealplanQuotData['mealPlanName'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							}
						} 
						if($sorting3['serviceType'] == 'additional'){ 
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
							$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
							if(mysqli_num_rows($b) > 0){
								$additionalQuotData=mysqli_fetch_array($b);
								$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
								$extraData=mysqli_fetch_array($rs1); 
								echo  "<p>".$cnt1.") <strong>Additional:</strong> ".strip($extraData['name'])."</p>";
								// if($cnt1 < $totolDays1){ echo "<br />"; }  
							}
						}  
						if($sorting3['serviceType'] == 'guide'){  
							$b=$where2="";		
							$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'" ';	
							$b=GetPageRecord('*','quotationGuideMaster',$where2); 
							if(mysqli_num_rows($b) > 0){
								$guideQuotData=mysqli_fetch_array($b);
							 
									$rs5="";  
								$rs5=GetPageRecord('*','tbl_guidesubcatmaster','id="'.$guideQuotData['guideId'].'"'); 
								$guideData=mysqli_fetch_array($rs5); 
								echo  "<p>".$cnt1.") <strong>Guide:</strong> ".strip($guideData['name'])."</p>"; 
								// if($cnt1 < $totolDays1){ echo "<br />"; } 
								 
							}
						}
						$cnt1++;
					}
					?>
				</span>
			</td>	
			</tr>
		</table>
		<?php 	 
		$day++; 
	} ?>
	<br />	
	<!-- <br />	  -->
	<table width="100%" cellpadding="25" cellspacing="0">
		<tr>
			<td><img src="<?php echo $fullurl; ?>images/end-of-tour.png" width="600" height="30" /></td>
		</tr>
	</table>
	<!-- <br />  -->
	<div class="dayTitle" style="line-height: 25px;font-size: 15px;color: white;text-align: left;background-color: #133f6d; page-break-after: never;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hotels Proposed</div>
	<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
	<tr>
	<td>
		<table width="100%" border="1" align="left" cellpadding="5" cellspacing="0" bordercolor="#ddd" class="borderedTable table-service" style="page-break-inside: always;page-break-after: auto;page-break-before: auto;width: 100%;">
		 	<tr>
				<th width="25%" align="left" valign="middle" bgcolor="#133f6d" style="color: #ffffff;"><strong>Dates</strong></th>
				<th width="20%" align="left" valign="middle" bgcolor="#133f6d" style="color: #ffffff;"><strong>City</strong></th>
				<th width="30%" align="left" valign="middle" bgcolor="#133f6d" style="color: #ffffff;"><strong>Hotel</strong></th>
				<th width="25%" align="left" valign="middle" bgcolor="#133f6d" style="color: #ffffff;"><strong>Room Type</strong></th>
	 			<!-- <th width="17%" align="left" valign="middle" bgcolor="#133f6d" style="color: #ffffff;"><strong>Remarks</strong></th> -->
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
			        // $hotelTypeLable .= "Guest,";
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
						echo date('j M Y',strtotime($sorting3['startDate']));  
						?></strong>
					</td>
					<td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']); ?></td>
					<td valign="middle"><?php echo "Hotel :- ".strip($hotelData['hotelName']).'<br> '.'<a target="_blank" href="'.$hotelData['url'].'">'.$hotelData['url'].'</a>' ; 

					$rtype='';
					$select121='*';  
					 $where121='hotelQuotId="'.$hotelQuotData['id'].'" and quotationId="'.$hotelQuotData['quotationId'].'" '; 
					$rs12=GetPageRecord($select121,'quotationHotelAdditionalMaster',$where121); 
					while ($editresult2=mysqli_fetch_array($rs12)) {
						$rtype  .= $editresult2['name'].', ';
					}
					echo "<br><br>Additionals: ".rtrim($rtype,', ');
					?>
					</td>
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
	<!-- <br /> -->
	<?php
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
	if($resultpageQuotation['flightCostType'] == 1 && mysqli_num_rows($betet)>0){  ?> 
	<div class="dayTitle" style="line-height: 25px;font-size: 15px;color: white;text-align: left;background-color: #133f6d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AIR FARE SUPPLEMENT</div>
	<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
		<tr>
			<td>
			<table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" class="borderedTable" style="width: 100%;">
				<tr>
					<th width="18%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Date</strong></th>
					<th width="17%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Sector</strong></th>
					<th width="30%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Flight/Timings</strong></th>
					<th width="22%" valign="middle" bgcolor="#133f6d" style="background-color: #133f6d;color: #ffffff;text-align: left;"><strong>Class/Baggage</strong></th>
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
						echo date('j M Y',strtotime($flightQuotData['fromDate']));  
						?></strong></td>
						<td valign="middle"><?php echo strip($departurefrom); ?>-<?php echo strip($arrivalTo); ?></td>
						<td valign="middle"><?php echo strip($flightQuotData['flightNumber']);  
						if(!empty($flightQuotData['departureTime']) || !empty($flightQuotData['arrivalTime'])){ echo " at ".date('Hi',strtotime($flightQuotData['departureTime']))."/".date('Hi',strtotime($flightQuotData['arrivalTime']))." Hrs"; }   ?></td>		
						<td valign="middle"><?php echo str_replace('_',' ',$flightQuotData['flightClass']);  ?> <?php //echo strip($flightQuotData['flightBaggage']);  ?></td>				
						<td valign="middle"><?php echo getCurrencyName($newCurr); ?> <?php $flightCost = ($flightQuotData['adultCost']); echo (getChangeCurrencyValue_New($defaultCurr,$quotationId,$flightCost)); ?></td>
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
	if(mysqli_num_rows($checkSuppHQuery) > 0 || mysqli_num_rows($suppRoomQuery) > 0){
		?>
		<div class="dayTitle" style="line-height: 25px;font-size: 15px;color: white;text-align: left;background-color: #133f6d;">Hotel/Room Supplement</div>
		<table border="0" cellpadding="20" cellspacing="0" borderColor="#ccc">
			<tr>
				<td>
				<div class="table-service" style="page-break-inside: always;page-break-after: auto;page-break-before: auto;" >
				<?php  
				$queryId = $resultpageQuotation['queryId'];
				$quotationId= $resultpageQuotation['id'];
				include('quotationSupplementHoteltable.php');
				?>
				</div>
				</td>
			</tr>
		</table>
		<!-- <br />	 -->
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
			<?php if($overviewText!=''){ ?> 
			<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Tour Overview
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($overviewText); ?>
		
			</td>
		</tr>
	</table>
	<br><br>
	<?php } if($highlightsText){ ?> 
		<table border="0" cellpadding="5" cellspacing="0"  width="100%" style="font-size:12px">
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
			<td style="font-size: 16px;text-align: left; page-break-inside: avoid;">&nbsp;&nbsp;&nbsp;&nbsp;Tour Highlights
			</td>
		</tr>
		<tr>
		<td>
		<?php echo strip($highlightsText); ?>
			</td>
		</tr>
	</table>
	<br><br>

		<?php } if($inclusion!=''){ ?> 
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
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
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
		<tr style="color:<?php if($colorResult['textColor']!=''){ echo $colorResult['textColor']; }else{ echo '#ffffff'; } ?>; background-color: <?php if($colorResult['proposalColor']!=''){ echo $colorResult['proposalColor']; }else{ echo '#133f6d'; } ?>;">
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

	
</div>
<?php 
	$selectF= 'footerstatus, footertext';
	$resfooter = GetPageRecord($selectF,'companySettingsMaster','id="1"');
    $resultf = mysqli_fetch_assoc($resfooter);
	if($resultf['footerstatus']==1){ ?> 
	<table width="100%" cellpadding="25" cellspacing="0" border="0" ><tr>
	<td align="center"><a style="color:green;" href="https://www.deboxglobal.com/best-travel-crm.html" target="_blank" ><?php if($resultf['footertext']!=''){ echo $resultf['footertext']; }else{ ?> Generated by TravCRM <?php } ?> </a></td></tr></table>
	<?php } ?>
</body>
</html>
