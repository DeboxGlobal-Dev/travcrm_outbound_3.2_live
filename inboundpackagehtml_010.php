<?php 
   	include "inc.php";  
 
	$select=''; 
	$where=''; 
	$rs='';   
	$select='*';  
	$where='id=1'; 
	$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
	$resultInvoiceSetting=mysqli_fetch_array($rs); 

	$selectx='*';   
	$wherex='id=1'; 
	$rsx=GetPageRecord($selectx,'lettersettings',$wherex); 
	$editresulx=mysqli_fetch_array($rsx); 

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
<div style="display:none;" class="calcostsheet">
<?php include_once("loadFITCostSheet.php"); ?>
</div>
 
<div style="margin-top:0px; margin:auto; width:800px; text-align:center;" class="news_content" id="pdfbody">
<table width="100%" cellpadding="0" cellspacing="0">
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
</table>
<table width="720" border="0" cellpadding="40" cellspacing="0" bordercolor="#000000" >

<tr>
  <td colspan="2"><table width="100%" cellspacing="2">
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top"><strong style="font-size: 20px;color: #ff0000;"><?php echo strtoupper(strip($resultpage['subject'])); ?></strong></td>
  </tr>
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top"><strong style="font-size: 16px;"><?php echo $resultpage['night']; ?>&nbsp;Nights&nbsp;/&nbsp;<?php echo $resultpage['night']+1; ?>&nbsp;Days</strong></td>
  </tr>
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top" style="font-size: 14px;">With</td>
  </tr>
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" width="400" /></td>
  </tr>
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top"><a style="text-decoration: underline;color: #1111cc;font-size: 16px;">WWW.DharmaAdventure.com</a></td>
  </tr>
</table>
</td>
</tr>
<tr>
  <td colspan="2"><table width="100%" cellspacing="10">
  <tr>
    <td align="left" colspan="2" valign="top" style="font-size:14px;color: #333333;"><strong style="font-size:20px;color:#ff0000;">Overview</strong><br><p><?php echo (str_replace('&nbsp;',' ',(stripslashes($overviewText)))); ?></p></td>
  </tr> 
</table>
</td>
</tr>

<tr>
 <td colspan="2"></td>
</tr> 	
<tr>
 <td colspan="2">
    <table width="100%" cellspacing="5" >
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top"><strong style="font-size:16px;color:#ff0000;">Proposed Itinerary</strong></td>
  </tr>
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top" style="font-size:14px;">Trip Date: <?php echo date('dS', strtotime($resultpageQuotation['fromDate'])); ?>-<?php echo date('dS M,Y', strtotime($resultpageQuotation['toDate'])); ?></td>
  </tr>
  <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top" style="font-size:14px;">The journey starts from <?php 				
			$day=1;
			$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$resultpageQuotation['id'].'" group by cityId order by srdate asc'); 
			while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
				$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
				$destname = getDestination($QueryDaysData['cityId']);
				?>  <?php echo $destname.','; ?><?php $day++; 
			} ?></td>
  </tr>
   <tr>
    <td width="1%" align="center" valign="top">&nbsp;</td>
    <td width="98%" align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><table border="1" cellpadding="5" cellspacing="0" bordercolor="#ddd" width="100%" style="font-size:12px;">
     
	    <tr>
         <th width="13%" valign="middle" align="center"><strong>Day</strong></th>
         <?php if($resultpage['dayWise'] == 1){ ?>
		<td width="13%" valign="middle" align="center"><strong>Date</strong></td>
		<?php } ?>
         <th width="54%" valign="middle" align="center"><strong>Program</strong></th>
         <th width="20%" valign="middle" align="center"><strong>Accommodation </strong></th>
       </tr>
	
	   <?php
		$quotationId=$resultpageQuotation['id'];
		$queryId=$resultpageQuotation['queryId']; 
		// day loop
 		$day=1;
		$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by id asc'); 
		while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
			$dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
			$dayId = $QueryDaysData['id']; 
			?>	
		<tr>
		<td align="center" valign="top">
			<?php echo $day; ?>
		</td>
		<?php if($resultpage['dayWise'] == 1){ ?><td valign="top" align="center"><?php echo date('d-M',strtotime($dayDate)); ?></td><?php } ?>
		<td align="left" valign="top"><?php
		// title and description
		if($QueryDaysData['title']!=''){
			$dayTitle = preg_replace('/\\\\/', '',clean($QueryDaysData['title']));
			echo stripslashes(str_replace('&nbsp;',' ',(urldecode($dayTitle))));
			echo "<br><br>";
		} 
		// services list
		$cnt1 = 1;
		//$itiQuery1 = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" order by srn asc';
		$itiQuery1 = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceId not in ( select id from quotationHotelMaster where quotationId="'.$quotationId.'" and isHotelSupplement!=1 )  and startDate="'.$dayDate.'" order by srn asc';
		$itineryDay1=GetPageRecord('*','quotationItinerary',$itiQuery1);  
		$totolDays1 = mysqli_num_rows($itineryDay1);
		while($sorting3 = mysqli_fetch_array($itineryDay1)){ 


			// echo "<strong>";
			if($sorting3['serviceType'] == 'transfer' || $sorting3['serviceType'] == 'transportation'){  
			
				$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
				$b=GetPageRecord('*','quotationTransferMaster',$where2); 
				if(mysqli_num_rows($b) > 0){
					$transferQuotData=mysqli_fetch_array($b); 
					$rsentn=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'id="'.$transferQuotData['transferNameId'].'"');  
					$transferData=mysqli_fetch_array($rsentn); 
					echo $cnt1.")&nbsp;".strip($transferData['transferName']);
					if($cnt1 < $totolDays1){ echo "<br>"; }  
					 
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
					echo  $cnt1.")&nbsp;".strip($entranceData['entranceName']);
					if($cnt1 < $totolDays1){ echo "<br>"; } 
					//ticketAdultCost
				}
			}
			if($sorting3['serviceType'] == 'activity'){ 
				$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
				$b=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,$where2); 
				if(mysqli_num_rows($b) > 0){
					$activityQuotData=mysqli_fetch_array($b);
					$rs1=GetPageRecord('*',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,' id ="'.$activityQuotData['otherActivityName'].'"');  
					$activityData=mysqli_fetch_array($rs1); 
					echo  $cnt1.")&nbsp;".strip($activityData['otherActivityName']);
					if($cnt1 < $totolDays1){ echo "<br>"; } 
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
					echo  $cnt1.")&nbsp;".strip($enrouteData['enrouteName']);
					if($cnt1 < $totolDays1){ echo "<br>"; } 
					//adultCost
				}
			} 
			if($sorting3['serviceType'] == 'mealplan'){ 
				$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
				$b=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where2); 
				if(mysqli_num_rows($b) > 0){
					$mealplanQuotData=mysqli_fetch_array($b);
					echo  $cnt1.")&nbsp;".strip($mealplanQuotData['name']);
					if($cnt1 < $totolDays1){ echo "<br>"; }  
				}
			} 
			if($sorting3['serviceType'] == 'additional'){ 
				$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'"';						
				$b=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$where2); 
				if(mysqli_num_rows($b) > 0){
					$additionalQuotData=mysqli_fetch_array($b);
					$rs1=GetPageRecord('*','extraQuotation','id="'.$additionalQuotData['additionalId'].'"'); 
					$extraData=mysqli_fetch_array($rs1); 
					echo  $cnt1.")&nbsp;".strip($extraData['name']);
					if($cnt1 < $totolDays1){ echo "<br>"; }  
				}
			}  
			if($sorting3['serviceType'] == 'guide'){  
				$where2='quotationId="'.$quotationId.'" and id="'.$sorting3['serviceId'].'" ';						
				$b=GetPageRecord('*','quotationGuideMaster',$where2); 
				if(mysqli_num_rows($b) > 0){
					$guideQuotData=mysqli_fetch_array($b);
					
					$rs11= ""; 
					$rs11 = GetPageRecord('*','dmcGuidePorterRate','id="'.$guideQuotData['guideId'].'"'); 
					$guideRateD = mysqli_fetch_array($rs11); 
					//echo 'id="'.$guideRateD['serviceid'].'"';
					$rs5="";  
					$rs5=GetPageRecord('*','tbl_guidesubcatmaster','id="'.$guideRateD['serviceid'].'"'); 
					$guideData=mysqli_fetch_array($rs5); 
					echo  $cnt1.")&nbsp;".strip($guideData['name']); 
					if($cnt1 < $totolDays1){ echo "<br>"; } 
					 
				}
			} 
			$cnt1++;
			   
		}	  
		?></td>	
		<td valign="top"><?php 
		// services list 
		$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
		
		$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
		while($itineryDayData = mysqli_fetch_array($itineryDay)){ 		
			if($itineryDayData['serviceType'] == 'hotel' ){
					$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
					while($sorting1=mysqli_fetch_array($b1)){ 
						 $where22='quotationId="'.$QueryDaysData['quotationId'].'" and isHotelSupplement!=1  and id="'.$sorting1['serviceId'].'"';   
						$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
						if(mysqli_num_rows($rs22) > 0){
							
							while($hotellisting=mysqli_fetch_array($rs22)){  
							$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotellisting['supplierId'].'"');  
							$hotelData=mysqli_fetch_array($rs1ee);   
							//hotel details
							 
							$rs12=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotellisting['roomType'].'"'); 
							$editresult2=mysqli_fetch_array($rs12);
							$rtype=$editresult2['name'];
							echo stripslashes($hotelData['hotelName']);
							
							}
						}
					}
				
			} 
			//end of services 
			   
		}	
		?></td>


.		</tr>
		<?php $day++; } ?>

			<tr>
		<td>&nbsp;</td>
		<?php if($resultpage['dayWise'] == 1){ ?><td>&nbsp;</td><?php } ?>
		<td>*************</td>
		<td>&nbsp;</td>
		</tr>
	
</table>
</td>
  </tr>
</table>

 </td>
</tr>

<tr>
	<td colspan="2">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-size:14px;">
	<?php 		 
	$day=1;
	$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
	while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
			$destname = getDestination($QueryDaysData['cityId']);
			$destSql = ' id="'.$QueryDaysData['cityId'].'" ';
			$destQuery=GetPageRecord('*','destinationMaster',$destSql);  
			$destData3 = mysqli_fetch_array($destQuery);

		  $itiQueryflth = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate12.'" and serviceType = "flight"';
			$destQuery=GetPageRecord('*','quotationItinerary',$itiQueryflth);  
			$itineryDayDataflth = mysqli_fetch_array($itineryDayflth);

			$where22flth='quotationId="'.$quotationId.'" and id="'.$itineryDayDataflth['serviceId'].'"'; 
			$rs22flth=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22flth);
			$flightQuoteDatah = mysqli_fetch_array($rs22flth);

			$departurefrom = $flightQuoteDatah['departureTime'];
			$arrivalTime = $flightQuoteDatah['arrivalTime'];

			$ts1 = strtotime($departurefrom);
      $ts2 = strtotime($arrivalTime);
      // echo $diff = abs($ts1 - $ts2) / 3600;
			
			$rsh=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteDatah['flightId'].'"');  
			$flightDatah=mysqli_fetch_array($rsh);
			
		if($day == 1){
			
			if($destData3['destinationImage']!=''){ 
				$destinationImage = '<tr><td colspan="2" align="center"><br><img src="'.$fullurl.'packageimages/'.$destData3['destinationImage'].'" width="722" height="325" /></td></tr>';
				echo $destinationImage;
			}
			$destinationImage = '';
			?>
			<tr><td colspan="2" align="left"><br><strong style="color:#ff0000;font-size: 16px;">Detailed&nbsp;Itinerary:</strong><br><br></td></tr> 
			<?php
		}		
		?>
		<tr><td colspan="2" align="left" style="color: #1f1f7d;
    font-weight: 600;"><strong>Day&nbsp;<?php echo $day; ?>,<?php echo date('dS M,Y', strtotime($dayDate12)); ?>:&nbsp;<?php if($day == 1){ echo "Arrive&nbsp;In&nbsp;".$destname; }else{  echo "&nbsp;".$destname; } ?></strong></td></tr> 
			<?php

			$itiQueryflt = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType = "flight"';
			$itineryDayflt1=GetPageRecord('*','quotationItinerary',$itiQueryflt);  
			$itineryDayDataflt1 = mysqli_fetch_array($itineryDayflt1);
			
			$where22flt1='quotationId="'.$quotationId.'" and id="'.$itineryDayDataflt1['serviceId'].'"'; 
			$rs22flt1=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,$where22flt1);
			$flightQuoteData1 = mysqli_fetch_array($rs22flt1);
			
			$rs1=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$flightQuoteData1['flightId'].'"');  
			$flightData=mysqli_fetch_array($rs1);
			
			$flightTitle = $destname.'-'.$flightData['flightName'].'-'.$flightQuoteData1['flightNumber'].'-'.$flightQuoteData1['departureTime'];
			if($QueryDaysData['title']!=''){  
				echo '<tr><td colspan="2" ><br><p style="text-align:justify">'.urldecode(strip($QueryDaysData['title'])).'</p></td></tr>';
			}

			//if flight exist
			if(mysqli_num_rows($rs22flt1) > 0){ ?>
			<tr><td colspan="2" align="left"><br><p><strong style='color:blue;font-size:14px;'><?php echo $flightTitle;?></strong></p><p style="color:green;">(Reporting time at the airport for domestic flight is at least 1.5 hours prior to flight departure time)</p></td></tr>
			<?php
			}
			
			// destination Image
			echo $destinationImage; 
			
			if($QueryDaysData['description']!=''){ ?>
			<tr><td colspan="2" ><br><p style="text-align:justify;"><?php echo urldecode($QueryDaysData['description']); ?></p></td></tr><?php
			} 
			
			if(++$chkLast==mysqli_num_rows($QueryDaysQuery)){  ?>
			<tr><td colspan="2" ><p style="text-align:justify;font-size:16px;"><?php  echo "Standard checkout Time 12:00pm - Departure"; ?></p></td></tr><?php
			}
			?>
		<tr>
		<td colspan="2" align="left">
		<?php					
		$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate12.'" group by serviceType order by srn asc,id desc';
		$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
		while($itineryDayData = mysqli_fetch_array($itineryDay)){
		 
			if($itineryDayData['serviceType'] == 'hotel' ){

				$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate12.'" and serviceType="hotel" order by srn asc,id desc'); 
				$cnt = 1;
				while($sorting1=mysqli_fetch_array($b1)){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"';   
					$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
					if(mysqli_num_rows($rs22) > 0){ 
						if( $cnt == 1){
						echo "<br><p>Overnight at ";
						}
						 
						while($hotelQouteData=mysqli_fetch_array($rs22)){  
							
							$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotelQouteData['roomType'].'"');  
							$roomtype=mysqli_fetch_array($rs23qwe);
							$roomType = $roomtype['name'];
							
							$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');  
							$hotelData=mysqli_fetch_array($rs1ee); 
							?>
							<a href="#"><?php echo stripslashes($hotelData['hotelName']);?>&nbsp;-&nbsp;<?php echo stripslashes($roomType);?></a>&nbsp;:&nbsp;<?php if($hotelQouteData['hotelDescription']==1){ echo $hotelData['hoteldetail']; } ?>/
							<?php
						}	
					}	
				$cnt++;
				}
				echo "<br><strong>Meals:&nbsp;Breakfast</strong></p><br>"; 
			}
			
			if($itineryDayData['serviceType'] == 'train' ){
				$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
				$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
				if(mysqli_num_rows($rs22) > 0){ ?>
					<table width="100%" align="left" border="0" cellpadding="4" cellspacing="0" style="font-size:12px;margin-bottom:10px;">
					<?php 
					while($trainQuoteData=mysqli_fetch_array($rs22)){
						$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
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

						?> 
						<tr>
						<td colspan="2">
						<p><?php echo"Train: ".strip($trainData['trainName']).' '.$journeyType .' from '.$jfrom.' to '.$jto." by ".strip($trainQuoteData['trainNumber']).' '.$dptTime.$avrTime.'/'.strip($trainQuoteData['trainClass']);?></p>		
						</td>
						</tr>
					<?php } ?>
					</table>
				<?php 
				} 	
			}	
		
		//end of the services loop
		}
		?>
		</td>
		</tr>
		<?php
		//end of the day loop   
		$day++;
	}
	?>
	<tr>
	<td colspan="2" align="left">
	<br>
	<p style="color:#00CC33;font-style:italic">(Reporting time at the airport for international flight is at least 3 hours prior to flight departure time)</p>
	<br>
	<p style="text-align: center;border-bottom: 1px solid gray;"><strong>Trip&nbsp;Ends</strong></p>	
	<br>
	<p style=" text-decoration: underline;"></p>
	<p>Note: All information in this itinerary is accurate to the best of our knowledge but please note that changes to our trips can and do occur.  This may be due to our effort to improve our program or logistical reasons such as changes in train/flight schedules, traffic conditions, weather conditions, or government policies. Dharma DMC India will make every effort to keep you informed of any changes but cannot be held liable for any alterations made to the published itinerary.</p>
	</td>
	</tr>
  	</table>
	</td>
</tr>

<tr>
	<td colspan="2">
	<table width="100%" cellspacing="0">
		<tr>
		<td colspan="2"><strong style="font-size: 16px;text-decoration: underline;" >THE&nbsp; NET&nbsp; LAND&nbsp; COST&nbsp; IN <?php echo getCurrencyName($quotationData['currencyId']); ?> &nbsp;PER &nbsp;PERSON &nbsp;ON <?php if($resultpageQuotation['sglRoom']!='0'){ echo 'SINGLE SHARING'; }if($resultpageQuotation['dblRoom']!='0'){ echo 'DOUBLE SHARING'; }if($resultpageQuotation['tplRoom']!='0'){ echo 'TRIPLE SHARING'; }if($resultpageQuotation['tplRoom']!='0' && $resultpageQuotation['dblRoom']!='0'){ echo 'TRIPLE SHARING','DOUBLE SHARING'; }if($resultpageQuotation['sglRoom']!='0' && $resultpageQuotation['dblRoom']!='0'){ echo 'SINGLE SHARING','DOUBLE SHARING'; }if($resultpageQuotation['sglRoom']!='0' && $resultpageQuotation['dblRoom']!='0' && $resultpageQuotation['tplRoom']!='0'){ echo 'SINGLE SHARING','DOUBLE SHARING','TRIPLE SHARING'; } ?> &nbsp;BASIS&nbsp; USING &nbsp;THE&nbsp; BELOW&nbsp; MENTIONED &nbsp;HOTELS:</strong><br /><br /></td>
		</tr>
		<tr>
		<td width="10%" align="left">&nbsp;</td>
		<td width="90%" align="left">
			<table width="90%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000" style="font-size:12px;">
			<tr>
			<td width="45%" align="left" bgcolor="#ddd"><strong>Hotels - Location</strong></td>
			<td width="40%" align="left" bgcolor="#ddd"><strong>Room Category</strong></td>
			<td width="15%" align="left" bgcolor="#ddd"><strong>Nights</strong></td>
			</tr> 
			<?php 				
		      $QueryDaysQuerydo=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
	          while($QueryDaysDatado=mysqli_fetch_array($QueryDaysQuerydo)){
		       $cityId = $QueryDaysDatado['cityId']; 
	           $dayId = $QueryDaysDatado['id']; 
	           $destname = getDestination($QueryDaysDatado['cityId']);
	           $wherech='quotationId="'.$QueryDaysDatado['quotationId'].'" and destinationId="'.$QueryDaysDatado['cityId'].'"';   
					$rsch=GetPageRecord('*','quotationHotelMaster',$wherech);
                    $counthotel = mysqli_num_rows($rsch); 

					$where22='quotationId="'.$QueryDaysDatado['quotationId'].'" and destinationId="'.$QueryDaysDatado['cityId'].'"  group by supplierId';   
					$rs22=GetPageRecord('*,count(id) as night','quotationHotelMaster',$where22);
                    
					if(mysqli_num_rows($rs22) > 0){
					while($hotelQouteData=mysqli_fetch_array($rs22)){ 

						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');  
					    $hotelData=mysqli_fetch_array($rs1ee);  

					    $select12='*';  
						$where12='id='.$hotelQouteData['roomType'].''; 
						$rs12=GetPageRecord($select12,_ROOM_TYPE_MASTER_,$where12); 
						$editresult2=mysqli_fetch_array($rs12);
				?>
				<tr>
				<td width="45%"><span><?php echo stripslashes($hotelData['hotelName']).' - '.$destname;?></span></td>
				<td width="40%"><span><?php echo $hotelQouteData['night'].' '.$editresult2['name']; ?></span></td>
				<td width="15%"><span><?php echo $hotelQouteData['night']; ?></span></td>
				</tr> 
			<?php
			  }}}
			?>

		  </table>
		 
		</td>
		</tr> 
		</table>
	</td>
</tr>
<tr>
	<td align="left" colspan="2">
		 <table width="100%" cellspacing="5" style="font-size: 12px;">
		  	   <tr>
			   	  <td width="50%"><strong>Based on <?php echo $quotationData['adult']; ?> Adults:</strong></td>
			   	  <td width="50%"><?php echo getCurrencyName($quotationData['currencyId']); ?><strong>&nbsp;<?php  //+$quotationData['otherLocationCost']
				$final_cost2 = round(($proposalCost/$totalPax),2); echo number_format(getChangeCurrencyValue_New($defaultCurr,$quotationId,$final_cost2)); ?></strong></td>
			   </tr>
			  <!--  <tr>
			   	  <td width="50%"><strong>11 year old Child (sharing room with parents):</strong></td>
			   	  <td width="50%"><strong>USD 2,000.00 per child </strong></td>
			   </tr> -->
			   <tr>
			   	  <td width="50%"><strong>TOTAL COST for <?php echo $totalPax; ?> PAX: <?php echo getCurrencyName($quotationData['currencyId']); ?> &nbsp;<?php  $final_cost = ($proposalCost+$quotationData['otherLocationCost']); echo number_format(getChangeCurrencyValue_New($defaultCurr,$quotationId,$final_cost)); ?> </strong></td>
			   	  <td width="50%"><strong></strong></td>
			   </tr>
		  </table>
	</td>
</tr>

<tr>
	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px;">
		
			<tr><td colspan="2" align="left"><br><strong style="font-size: 16px;text-decoration: underline;">COST&nbsp;INCLUDES:</strong><br></td></tr>
<?php 

 $QueryDaysQueryp1=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" group by cityId order by id asc'); 
	while($QueryDaysData1=mysqli_fetch_array($QueryDaysQueryp1)){
		$cityId = $QueryDaysData1['cityId']; 
	    $dayId = $QueryDaysData1['id']; 
	    $destname = getDestination($QueryDaysData1['cityId']);  

 ?>				
			
			<tr>
				<td colspan="2" width="100%" align="left" ><strong><?php echo $destname; ?>:</strong><br>
					<ul>
<?php
                    $wherech='quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'"';   
					$rsch=GetPageRecord('*','quotationHotelMaster',$wherech);
                     

					$where22='quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'"  group by supplierId';   
					$rs22=GetPageRecord('*,count(id) as night','quotationHotelMaster',$where22);
                    $counthotel = mysqli_num_rows($rs22);
					if(mysqli_num_rows($rs22) > 0){
					while($hotelQouteData=mysqli_fetch_array($rs22)){ 

						$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');  
					    $hotelData=mysqli_fetch_array($rs1ee); 
		 ?>					
                       <li><p><?php echo $hotelQouteData['night']; ?> Nights, hotel accommodation at <?php echo stripslashes($hotelData['hotelName']);?> on <?php if($resultpageQuotation['sglRoom']!='0'){ echo 'single sharing'; }if($resultpageQuotation['dblRoom']!='0'){ echo 'double sharing'; }if($resultpageQuotation['tplRoom']!='0'){ echo 'triple sharing'; }if($resultpageQuotation['tplRoom']!='0' && $resultpageQuotation['dblRoom']!='0'){ echo 'triple sharing','double sharing'; }if($resultpageQuotation['sglRoom']!='0' && $resultpageQuotation['dblRoom']!='0'){ echo 'single sharing','double sharing'; }if($resultpageQuotation['sglRoom']!='0' && $resultpageQuotation['dblRoom']!='0' && $resultpageQuotation['tplRoom']!='0'){ echo 'single sharing','double sharing','triple sharing'; } ?> based on bed<?php if($hotelQouteData['complimentaryDinner']!='0'){ echo 'and dinner basis'; }if($hotelQouteData['complimentaryLunch']!='0'){ echo 'and lunch basis'; } ?>.</p></li>
        <?php  }} ?> 
        	<?php 
           $b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and serviceType="mealplan" order by srn asc,id desc'); 
				$cnt = 1;
				while($sorting1=mysqli_fetch_array($b1)){ 
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and queryId="'.$QueryDaysData1['queryId'].'"';   
					$rs22=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$where22);

					if(mysqli_num_rows($rs22) > 0){?>
			
                        <li><p>Lunch & Dinner will be provided at selected local restaurants.</p></li>
                       
        <?php $cnt++; }}?>
        <?php 
           $b1=GetPageRecord('*','quotationItinerary','quotationId="'.$quotationId.'" and queryId="'.$queryId.'"  and serviceType="transfer"  order by srn asc,id desc'); 
				
				while($sorting1=mysqli_fetch_array($b1)){ 
					// echo 'quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'" and id="'.$sorting1['serviceId'].'" group by transferNameId';
					$c=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,'quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'" and id="'.$sorting1['serviceId'].'"');
					   $counttranfer = mysqli_num_rows($c); 
						while($resListing=mysqli_fetch_array($c)){
                  
						$d=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' id="'.$resListing['transferNameId'].'"');   
						$transferData1=mysqli_fetch_array($d);
						if($resListing['transferName'] == '' || strlen($resListing['transferName']) < 3){
							$transferName =  $transferData1['transferName'];
						}else{
							$transferName =  $resListing['transferName'];
						}

						$select2='carType,model';  
					    $where2='id="'.$resListing['vehicleModelId'].'"'; 
					    $rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
					    $editresult2=mysqli_fetch_array($rs2);
                        
					    $model .= $editresult2['model'].',';
	    }}


	    
	    	$b1=GetPageRecord('*','quotationItinerary','quotationId="'.$quotationId.'" and queryId="'.$queryId.'"  and serviceType="additional"  order by srn asc,id desc');
	    	while($sorting1=mysqli_fetch_array($b1)){ 
	    		$cvisa=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' quotationId="'.$QueryDaysData1['quotationId'].'" and id="'.$sorting1['serviceId'].'"');
	    		
				while($resListing=mysqli_fetch_array($cvisa)){
                   $d=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,' id="'.$resListing['additionalId'].'" and name="VISA"');
                   $countvisa = mysqli_num_rows($d);
                   $visaData1=mysqli_fetch_array($d);

                   $dm=GetPageRecord('*',_EXTRA_QUOTATION_MASTER_,' id="'.$resListing['additionalId'].'" and name="Meet assistance at the airport"');
                   $countassistent = mysqli_num_rows($dm);
                   $assistentData1=mysqli_fetch_array($dm);
                    // print_r($assistentData1);
                  
                   if($visaData1['name']=='VISA'){
                   	 $visadata = $destname.'&nbsp;visa fee.'; 
                   }
                   if($assistentData1['name']=='Meet assistance at the airport'){
                      $meetassis = 'Meet assistance at the airport.';
                   }

				}
	    	}
	    
	               		    
					
		 ?>					
                                  

 <?php  ?>            
                        <?php if($counttranfer>0){?><li><p>All the sightseeing tour and transfers as per the itinerary in a <?php echo $model; ?> vehicle accompanied by an English speaking local guide.</p></li>
                        <?php } ?>
                        <?php if($counttranfer>0){?>
                        <li><p>Arrival /departure transfers.</p></li>
                        <?php } ?>
                        <?php if($countvisa>0) {?>
                        <li><p><?php echo $visadata; ?></p></li>
                        <?php } ?>
                        <?php if($countassistent>0){?>
                        <li><p><?php echo $meetassis; ?></p></li>
                        <?php } ?>
                        <?php if($counttranfer>0){?>
                        <li><p>Wet Wipes, first-aid box, tissue box, bottled water, snacks and fruits available in the vehicles. </p></li> 
                        <?php } ?>            
                    </ul>
                </td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%" border="0" cellpadding="3" cellspacing="0"  style="font-size:12px;">
						<?php 
	                     $wherevc1='quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'"';   
			             $rsvc1=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$wherevc1); 
			             $whereea1='quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'"';   
				         $rsea1=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$whereea1);
				         $countenterance=mysqli_num_rows($rsvc1);

			             $countvisa=mysqli_num_rows($rsea1);
                         if($countvisa>0 || $countenterance>0){
			             ?>	
						   <tr><td colspan="2" align="left"><strong style="text-decoration: underline;">Additional/Entrance&nbsp;Activities &nbsp;included:</strong></td></tr>
					     <?php } ?>
						 <?php 
				   	$wherevc='quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'"  group by name';   
					$rsvc=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,$wherevc);
					if(mysqli_num_rows($rsvc) > 0){
					while($visaQouteData=mysqli_fetch_array($rsvc)){

             ?>			
               <tr><td width="100%" align="left">
               	  <ul>
               	  	<li><p><?php echo $visaQouteData['name'].' in '.$destname; ?></p></li>
               	  </ul>
               </td></tr>
            <?php }}

             	$whereea='quotationId="'.$QueryDaysData1['quotationId'].'" and destinationId="'.$QueryDaysData1['cityId'].'"';   
				$rsea=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,$whereea);
                if(mysqli_num_rows($rsea) > 0){
                 while($entranceQouteData=mysqli_fetch_array($rsea)){

                   $dm=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$entranceQouteData['entranceNameId'].'"');
                   $entrancedata=mysqli_fetch_array($dm);


                 ?>			
                   <tr><td width="100%" align="left">
               	    <ul>
               	  	   <li><p><?php echo $entrancedata['entranceName'].' in '.$destname; ?></p></li> 
               	    </ul>
                  </td></tr>
                <?php }}
                ?>

					</table>
				</td>
			</tr>
	    

<?php } ?>	
            
		</table>
	</td>
</tr>

<!-- <tr>
	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px;">
			<tr><td colspan="2" align="left"><br><strong style="font-size: 16px;text-decoration: underline;">COST&nbsp;EXCLUDES:</strong></td></tr>
			<tr>
				<td width="100%">
					<p style="font-size: 14px;"><?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($inclusion)))); ?></p>
                </td>
			</tr>
		</table>
	</td>
</tr>
 -->
 <tr>
              <td colspan="2" align="left" valign="top"><strong style="font-size:15px;">General&nbsp;Inclusion</strong><br />
              <p style="font-size: 14px;"><?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($inclusion)))); ?></p></td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top"><strong style="font-size:15px;">Cost&nbsp;Exclusion</strong><br />
             <p style="font-size: 14px;"><?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($exclusion)))); ?></p></td>
            </tr>

            <tr>
              <td colspan="2" align="left" valign="top"><strong style="font-size:15px;">Terms&nbsp;and&nbsp;Conditions&nbsp;of&nbsp;Payments:</strong><br />
             <p style="font-size: 14px;"><?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($resultInvoiceSetting['termscondition'])))); ?></p></td>
            </tr>

    <tr>
<td colspan="2">&nbsp;</td>
</tr>

<tr>
	<td colspan="2" align="center"><a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666;">Genrated by TravCRM</a> </td>
</tr>
</table>
</div>  