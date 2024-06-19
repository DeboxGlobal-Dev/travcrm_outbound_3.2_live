<?php 
	include "inc.php";   
	 
	$rsp = "";
	$rsp = GetPageRecord('*', _QUOTATION_MASTER_, 'id="'.decode($_REQUEST['id']).'"');
	$resultpageQuotation = mysqli_fetch_array($rsp);

	$rs = '';
	$rs = GetPageRecord('*', _QUERY_MASTER_, 'id="'.($resultpageQuotation['queryId']).'"');
	$querydata = mysqli_fetch_array($rs);
	
	$quotationId = $resultpageQuotation['id'];
	$queryId = $querydata['id'];

	if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
		$inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
	}
	if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
		$exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
	}
	if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
		$tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
	}

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

	echo '<table cellpadding="10" cellspacing="0" bordercolor="#000000" > <tr> <td colspan="2" style="border: 5px solid #dfdfdf;display:none;">';
	include('loadGITCostSheet.php');
	echo '</td></tr></table>';
	?>


<div style="margin-top:30px; margin:auto; width:775px; text-align:center;" class="news_content">
<table width="745" border="0" cellpadding="10" cellspacing="0" bordercolor="#000000">
  <tr>
    <td align="center" valign="top"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo;?>" width="740" /></td>
  	</tr> 
<tr>
	<td width="100%" align="left"  style="font-size:20px;	"><strong style="background-color:#ffeb3b;"><?php echo strtoupper(strip($querydata['subject'])); ?></strong>	</td>
</tr> 

<tr>
	<td>
	<table width="99%" border="0" cellpadding="5" cellspacing="0" bordercolor="#000000" style="font-size:12px;padding:10px 30px;">
		<tr><td colspan="2" align="left"><u><strong>ITINERARY</strong></u></td></tr> 
		<?php		
	
		$chkLast = 0;
		$day=1;
		$QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
		while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){
			$dayDate = date('Y-m-d',strtotime($QueryDaysData['srdate']));
			// get the fromdestination Id
			$destname = getDestination($QueryDaysData['cityId']);
			if($day == 1){
			?>
			<?php
			}		
			if($QueryDaysData['title']!=''){  
				$dayTitle = '<span style="font-weight:300;text-align:justify">'.urldecode(strip($QueryDaysData['title'])).'</span>';
			}
			?>
			<tr>
				<td colspan="2" align="left">
				<strong><?php if($querydata['dayWise'] == 1){ echo date('d M (D)',strtotime($dayDate)); } else{ echo "Day&nbsp;".$day; } ?>:&nbsp;<?php if($QueryDaysData['title']!=''){ echo $dayTitle; }else{ if($day == 1){ "Arrive&nbsp;"; } echo $destname;  } ?></strong>
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
				
				//if flight exist
				if(mysqli_num_rows($rs22flt1) > 0){ ?>
				<div style=""><?php echo $flightTitle;?></div>
				<?php
				}
				if($QueryDaysData['description']!=''){ ?>
				<div style="font-weight:300;text-align:justify;"><?php echo urldecode($QueryDaysData['description']); ?></div>
				<?php
				}
				if(++$chkLast==mysqli_num_rows($QueryDaysQuery)){  ?>
				<div style="font-weight:300;text-align:justify;"><?php  echo "Standard checkout Time 12:00pm - Departure"; ?></div>
				<?php
				}
				?>
				</td>
			</tr>
			<tr>
			<td colspan="2" align="left">
			<?php					
			$itiQuery = ' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" group by serviceType order by srn asc,id desc';
			$itineryDay=GetPageRecord('*','quotationItinerary',$itiQuery);  
			while($itineryDayData = mysqli_fetch_array($itineryDay)){
		 
				if($itineryDayData['serviceType'] == 'hotel' ){
					$b1=GetPageRecord('*','quotationItinerary',' quotationId="'.$quotationId.'" and queryId="'.$queryId.'" and startDate="'.$dayDate.'" and serviceType="hotel" order by srn asc,id desc'); 
					$cnt = 1;
					echo "<p>Overnight at ";
					while($sorting1=mysqli_fetch_array($b1)){ 
						$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$sorting1['serviceId'].'"';   
						$rs22=GetPageRecord('*','quotationHotelMaster',$where22);  
						if(mysqli_num_rows($rs22) > 0){ 
							//if( $cnt == 1){
							
							//}
							 
							while($hotelQouteData=mysqli_fetch_array($rs22)){  
								$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$hotelQouteData['roomType'].'"');  
								$roomtype=mysqli_fetch_array($rs23qwe);
								$roomType = $roomtype['name'];
								
								$rs1ee=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelQouteData['supplierId'].'"');  
								$hotelData=mysqli_fetch_array($rs1ee); 
								?>
								<a href="#"><?php echo stripslashes($hotelData['hotelName']);?></a>&nbsp;-&nbsp;<?php echo stripslashes($roomType);?>&nbsp;/
								<?php
							}	
						}	 
						$cnt++;
					}
					echo "</p>";
				}
				
				if($itineryDayData['serviceType'] == 'train' ){
					$where22='quotationId="'.$QueryDaysData['quotationId'].'" and id="'.$itineryDayData['serviceId'].'" order by id desc'; 
					$rs22=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,$where22);  
					if(mysqli_num_rows($rs22) > 0){ 
						while($trainQuoteData=mysqli_fetch_array($rs22)){
							$rs1=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$trainQuoteData['trainId'].'"');  
							$trainData=mysqli_fetch_array($rs1);   
							?><p><?php echo getDestination($trainQuoteData['departureFrom']);?>/&nbsp;<?php echo getDestination($trainQuoteData['arrivalTo']);?>&nbsp;-&nbsp;<?php echo $trainData['trainName'];?>&nbsp;-&nbsp;<?php echo $trainQuoteData['trainNumber'];?>&nbsp;-&nbsp;<?php echo $trainQuoteData['departureTime'];?></p>	
						<?php } ?>
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
		<td colspan="2" align="center"><p style="font-style:italic;">End of the Tour</p></td>
		</tr>
  	</table>
	</td>
</tr>
<tr>
	<td align="left">&nbsp;</td>
</tr>
<tr>
	<td align="left"><strong></strong></td>
</tr>
<tr>
	<td align="left">	
		<table width="100%" border="1" cellpadding="7" cellspacing="0" bordercolor="#ccc" >
				<?php $hotCategory2 = explode(',',$resultpageQuotation['hotCategory']); if($querydata['dayWise'] == 1){ $col=3; }else{ $col=2; }?>
				<tr style="font-size:13px;">
				<td valign="middle" align="center" bgcolor="#b7ca9a" colspan="<?php echo (count($hotCategory2)+$col); ?>"><strong>Hotel Envisaged :-</strong></td>
				</tr>
			  	<tr style="font-size:13px;">
				<td valign="middle" bgcolor="#b7ca9a"><strong>City</strong></td>
				<td align="center" bgcolor="#b7ca9a" valign="middle" > <strong>No. Of Nights </strong></td>
				<?php if($querydata['dayWise'] == 1){ ?>
				<td valign="middle" bgcolor="#b7ca9a"><strong>Date</strong></td>
				<?php }  					 
			 
				$hotCategory = explode(',',$resultpageQuotation['hotCategory']);				
				foreach($hotCategory as $val){
					$rsname=GetPageRecord('*','hotelCategoryMaster','id='.$val.'');  
					$hotelCatData=mysqli_fetch_array($rsname);
					?>
					<td valign="middle" bgcolor="#b7ca9a"><strong>Hotel&nbsp;[<?php echo $hotelCatData['hotelCategory'];?>*]</strong></td>
					<?php 
 				} 	
				?>  
				
				</tr>
				<?php 
 				$b=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.decode($_REQUEST['id']).'"  group by fromDate order by fromDate asc');
				while($hotelQuotData=mysqli_fetch_array($b)){ 
					$isEarlyCheckIn = "";
					if($hotelQuotData['fromDate'] < $quotationData['fromDate']){
						$isEarlyCheckIn = "&nbsp;|&nbsp;Early&nbsp;CheckIn";
					}
				$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
				$hotelData=mysqli_fetch_array($d);
				
				$start = strtotime($hotelQuotData['fromDate']);
				$end = strtotime($hotelQuotData['toDate']);
				$days_between='';
				$days_between = ceil(abs($end - $start) / 86400);
				?> 
				<tr style="font-size:12px;">
				<td valign="middle"><?php echo getDestination($hotelQuotData['destinationId']).$isEarlyCheckIn; ?></td>
				<td align="center" valign="middle"><?php echo $days_between+1; ?> N</td> 
				<?php if($querydata['dayWise'] == 1){ 
				$dayDates = date('Y-m-d', strtotime('+1 day', strtotime($hotelQuotData['toDate'])));
				?>
				<td valign="middle"><?php echo date('j M',strtotime($hotelQuotData['fromDate']));  ?> / <?php echo date('j M',strtotime($dayDates));  ?></td>
				<?php } ?>				
				<?php
				$hotCategory = explode(',',$resultpageQuotation['hotCategory']);				
				foreach($hotCategory as $val){
					///echo "Samaydin";
					$whereHot=GetPageRecord('supplierId,categoryId,roomType','quotationHotelMaster','quotationId="'.decode($_REQUEST['id']).'" and fromDate="'.$hotelQuotData['fromDate'].'" and toDate="'.$hotelQuotData['toDate'].'" and categoryId="'.$val.'" group by categoryId order by id asc');  
					$day = 1;
					//echo mysqli_num_rows($whereHot);
					if(mysqli_num_rows($whereHot) > 0){
						while($resHotel=mysqli_fetch_array($whereHot)){
					
							$rsname=GetPageRecord('hotelName,hotelCategoryId',_PACKAGE_BUILDER_HOTEL_MASTER_,'id='.$resHotel['supplierId'].'');  
							$hotelname=mysqli_fetch_array($rsname);
							
							$rs23qwe=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$resHotel['roomType'].'"');  
							$roomtype=mysqli_fetch_array($rs23qwe);
							$roomType = $roomtype['name'];
							
							?>
							<td valign="middle" ><?php echo $hotelname['hotelName']; ?>&nbsp;-&nbsp;<?php echo $roomType;?></td>
							<?php 
							$day++;
						}
					}	 
					else{
					?>
					<td valign="middle" bgcolor="#F4F4F4"><strong>&nbsp;</strong></td>
					<?php 
					}
				} 	
				?>
				</tr>	
				<?php } ?>
		</table>	
	</td>
</tr>
<tr>
	<td align="left">&nbsp;</td>
</tr>
<tr>
	<td align="left"><strong style="font-size:14px;"><u>Price for Land arrangements: (Per Person in <?php echo getCurrencyName($quotationData['currencyId']); ?> on Selected Room basis &nbsp;)</u></strong></td>
</tr>
<tr>
	<td align="left">
		<table width="100%" border="1" cellspacing="0" cellpadding="6" bordercolor="#ccc">		
			<?php 
			
			if($querydata['seasonType'] == 3){ 
				$colm = 2; 
			}else{
				$colm = 1;
			}
			
			$hotCategory2 = explode(',',$resultpageQuotation['hotCategory']);
			// echo $resultpageQuotation['id'];
			$widttth = count($hotCategory2); 
			$widths = 100/($colm*$widttth+1);
			$widths2 = $widths*$widttth;
			$colm1 = ($colm*$widttth+1);
	
			?>
			<tr bgcolor="#8fbcf3">
				<td colspan="<?php echo $colm1; ?>%" align="center" ><strong>Price based on selected room basis</strong></td>
			</tr>
			<tr bgcolor="#8fbcf3">
				<td width="<?php echo $widths; ?>%" rowspan="2"  align="center" ><strong>No. of Pax</strong></td>
 				<?php 
					for ($i = 1; $i <= $colm; $i++) {  
						if($querydata['seasonType'] == 1 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  } 
						if($querydata['seasonType'] == 2 && $i == 1){ $seasonPeriod = "01 Oct - 31 March"; } 
						if($querydata['seasonType'] == 3 && $i == 1){ $seasonPeriod = "01 Apr - 30 Sept";  } 
						else { $seasonPeriod = "01 Oct - 31 March"; } 
						?>
						<td width="<?php echo $widths2; ?>%" colspan="<?php echo count($hotCategory2);?>" align="center"><strong>Validity&nbsp;[&nbsp;<?php echo $seasonPeriod; ?>]</strong></td>
						<?php 
					} 
				?>
			</tr> 
			<tr bgcolor="#8fbcf3">
				 
 				<?php
 					for ($i = 1; $i <= $colm; $i++) { 			
						foreach($hotCategory2 as $val2){ 
						$rsname1=GetPageRecord('*','hotelCategoryMaster','id="'.$val2.'"');  
						$hotelCatData1=mysqli_fetch_array($rsname1);
						$hotelCategory = $hotelCatData1['hotelCategory'].' Star';
						?>
						<td width="<?php echo $widths; ?>%"  align="right"><strong><?php echo $hotelCategory; ?></strong></td>
						<?php 
					 	} 
					} 
				?>
			</tr>
			<?php 	
			$rsn=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' deletestatus=0 and country!=0 and status=1 and setDefault= 1'); 
			$resListingnn=mysqli_fetch_array($rsn);
			if($resListingnn['id'] == '' || $resListingnn['id'] == 0){
				$defaultCurr = 1;
			}else{
				$defaultCurr = $resListingnn['id'];
			}
			if($quotationData['currencyId'] == '' && $quotationData['currencyId'] == 0 ){
				$newCurr = $defaultCurr;
			}else{
				$newCurr = $quotationData['currencyId'];
			}
			
			$slabSql=GetPageRecord('*','totalPaxSlab',' quotationId="'.$quotationId.'" and status=1 order by fromRange asc'); 
			if(mysqli_num_rows($slabSql) > 0){
				while($slabsData=mysqli_fetch_array($slabSql)){ 
					$slabId = $slabsData['id'];
					if($slabsData['fromRange'] == $slabsData['toRange'] || $slabsData['fromRange']==0 || $slabsData['toRange']==0){
						$paxrange2 = $slabsData['fromRange'];
					}else{
						$paxrange2 = $slabsData['fromRange']."-".$slabsData['toRange'];
					} 
					${"final_cost".$slabId} = 0;					
					?>
					<tr>
					<td width="<?php echo $widths; ?>%" align="center" ><strong><?php echo $paxrange2; ?>&nbsp;Pax</strong></td>
					<?php			
					for ($i = 1; $i <= $colm; $i++) { 				
						foreach($hotCategory2 as $val2){
							$slabId11 = $slabId.'C'.$val2;
	 						${"proposalCost".$slabId11} = (${"proposalCost".$slabId11}+$quotationData['otherLocationCost']); 
							?>
							<td width="<?php echo $widths; ?>%" align="right"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,${"proposalCost".$slabId11}); ?></td>
						<?php } 
					} ?>	
					</tr>
				<?php 
				}
			} 
			?>
			<?php if($resultpageQuotation['isSupp_TRR'] == 1){ ?>
			<tr>	
				<td width="<?php echo $widths; ?>%" align="center" ><strong>Single&nbsp;Suppliment</strong></td>
				<?php		
				for ($i = 1; $i <= $colm; $i++) { 					
				foreach($hotCategory2 as $val2){
					  $val2 = $val2.$i;
					  ${"singleSuppliment" . $val2} = 0;
					$singleSuppliment = ${"singleSuppliment" . $val2};
  					?>
					<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$singleSuppliment); ?>&nbsp;<strong><?php echo getCurrencyName($quotationData['currencyId']); ?></strong></td>
				<?php } } ?>
			</tr>
			<tr>
			<td width="<?php echo $widths; ?>%" align="center" ><strong>Tripple&nbsp;Reduction</strong></td>			
			<?php			
			for ($i = 1; $i <= $colm; $i++) { 				
			foreach($hotCategory2 as $val2){
			 	$val2 = $val2.$i;
 				$tripleRateReduction = ${"tripleRateReduction" . $val2}; 
			?>
			<td width="<?php echo $widths; ?>%" align="center"><?php echo getChangeCurrencyValue_New($defaultCurr,$quotationId,$tripleRateReduction); ?>&nbsp;<strong><?php echo getCurrencyName($quotationData['currencyId']); ?></strong></td>
			<?php } } ?>
			</tr>			
			<?php } ?>
		</table>	
	</td>	
</tr>

   
<tr>
	<td>
	<table width="99%" border="0" cellpadding="10" cellspacing="0" style="font-size:12px;">
	<tr>
	  	<td align="left"><strong>Cost&nbsp;Includes:</strong><br>
		<?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($inclusion)))); ?>
		</td>
	</tr>
	<tr>
	  	<td align="left"><strong>Cost&nbsp;Excludes:</strong><br>
		<?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($exclusion)))); ?>
		</td>
	</tr>
	<tr>
	  <td align="left"><strong>REMARKS:</strong><br>
		<?php echo stripslashes(str_replace('&nbsp;',' ',(stripslashes($tncText)))); ?>
		</td>
	</tr>
	</table>	
	</td>
</tr>
<tr>
	<td align="center"><a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666;">Genrated by TravCRM</a> </td>
</tr>
</table>
</div>
