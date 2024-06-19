<?php
include "inc.php"; 

$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"'); 
$quotationData=mysqli_fetch_array($rsp);  
 
$suppQuery=""; 
$suppQuery = ' id = "'.$_REQUEST['supplierId'].'"';
 
$suppSql=GetPageRecord('*','suppliersMaster',$suppQuery); 
while($supplierData=mysqli_fetch_array($suppSql)){ 
?>
<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:20px;">
	<thead>
		<tr>  
		<th align="left" bgcolor="#ddd"><strong style="font-size: 10px; color: #649d5c;">Supplier:<br></strong><?php echo stripslashes(trim($supplierData['name'])); ?></th>
		<th align="left" bgcolor="#ddd"><strong style="font-size: 10px; color: #649d5c;">Payment&nbsp;Terms: <br></strong><?php echo ($supplierData['paymentTerm'] == 1)?"CASH":"ON CREDIT";?></th>
		<th align="left" bgcolor="#ddd">&nbsp;</th>
		<th align="right" bgcolor="#ddd">&nbsp;</th> 
		</tr>
	</thead>
	<tbody >  
		<tr>
		<td width="100%" colspan="4" align="left" valign="top" style="padding:10px !important; ">
		<?php 
		$b=	"";
		$b=GetPageRecord('*','finalQuote',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierData['id'].'" group by hotelId order by id asc'); 
		if(mysqli_num_rows($b) > 0){
			while($finalQuotData=mysqli_fetch_array($b)){ 
			
				$d="";
				$d=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' id="'.$finalQuotData['hotelQuotationId'].'"');   
				$hotelQuotData=mysqli_fetch_array($d);
				
				$d="";
				$d=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,' id="'.$hotelQuotData['supplierId'].'"');   
				$hotelData=mysqli_fetch_array($d);
				
				//check if supplier is self
				$supplierId = $finalQuotData['supplierId'];  
							
				$rs121=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id='.$hotelQuotData['roomType'].''); 
				$editresult21=mysqli_fetch_array($rs121);
				$rtype=$editresult21['name'];
				 
				
				$bfd=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationData['id'].'" and supplierId="'.$hotelQuotData['supplierId'].'" and supplierMasterId="'.$hotelQuotData['supplierMasterId'].'" order by fromDate asc');
				$hotelfd=mysqli_fetch_array($bfd);
				
				$btd=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationData['id'].'" and supplierId="'.$hotelQuotData['supplierId'].'" and supplierMasterId="'.$hotelQuotData['supplierMasterId'].'" order by fromDate desc');
				$hoteltd=mysqli_fetch_array($btd); 
				
				$hotelDates = date('d',strtotime($hotelfd['fromDate']))." - ".date('d M, Y',strtotime($hoteltd['toDate']. ' +1 day')); 
				
				$earlier1 = new DateTime($hotelfd['fromDate']);
				$later1 = new DateTime(date('Y-m-d',strtotime($hoteltd['toDate']. ' +1 day')));
				$nightstay=0;
				
				$nightstay=$later1->diff($earlier1)->format("%a");
				
				if($nightstay == 0){ $nightstay = $nightstay+1;}else{ $nightstay; } 
				
				if($listingyes['supplierId']!='' && $listingyes['supplierId']!=0){
					$supplierId = $listingyes['supplierId'];
				}
				
				$hcity = strip($hotelData['hotelCity']);
				
				$rssda24=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$hotelQuotData['mealPlan'].'"'); 
				$mealplan=mysqli_fetch_array($rssda24); 
				$mealplan = $mealplan['name'].'-'.$mealplan['subname'];
				
				$rsh="";
				$rsh=GetPageRecord('*','finalquotationItinerary','serviceType="hotel" and confirmStatus=0 and supplierId="'.$supplierData['id'].'" and finalServiceId="'.$finalQuotData['id'].'" and quotServiceId="'.$hotelQuotData['id'].'" and serviceId="'.$hotelData['id'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');   
				if(mysqli_num_rows($rsh) < 1){
					$namevalue ='serviceType="hotel",confirmStatus=0,supplierId="'.$supplierId.'",finalServiceId="'.$finalQuotData['id'].'",quotServiceId="'.$hotelQuotData['id'].'",serviceId="'.$hotelData['id'].'",dayId=0,quotationId="'.$quotationData['id'].'",queryId="'.$quotationData['queryId'].'",startDate="'.$hotelfd['fromDate'].'",endDate="'.$hoteltd['toDate'].'",srn="'.$srno.'"';  
					$lastId = addlistinggetlastid('finalquotationItinerary',$namevalue); 
				}
			?>
			<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:5px;     border: 1px solid #ddd;position:relative;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
				<tbody>
				<tr>
				  <td colspan="2" valign="bottom"  bgcolor="#F4F4F4">
				  <input type="hidden" value="<?php echo $listingyes['id'];?>" id="hotelfinalId<?php echo $hotelQuotData['id']; ?>">
				  Hotel:&nbsp;<?php echo strip($hotelData['hotelName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($hotelData['hotelCity']);  ?>&nbsp;)&nbsp;|&nbsp;<?php echo $rtype; ?>&nbsp;|&nbsp;<?php echo $mealplan; ?></td>
				  <td align="right"  bgcolor="#F4F4F4"><span style="margin-bottom:5px; font-size:12px;"><?php echo $hotelDates; ?></span>&nbsp;|&nbsp;<?php echo $nightstay; ?>&nbsp;Night(s)</td> 
				</tr>
				 
				  
				</tbody> 
				</table> 
			</div>		
			<?php 	 
			}  
		}
		
		$b=	"";
		$b=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierData['id'].'" order by id asc'); 
		if(mysqli_num_rows($b) > 0){  
		
			$vehicleCost= 0;	
			$vehicleCost2= 0;
			while($finalQuotTransfer=mysqli_fetch_array($b)){
		
				// hotel data
				$d="";
				$d=GetPageRecord('*','packageBuilderTransportMaster',' id="'.$finalQuotTransfer['transferId'].'"');   
				$transferData=mysqli_fetch_array($d); 
				
				$vehicleCost2 = trim($transferQuotData['vehicleCost']);
				
				$transferId = $transferData['id'];
			
				$rsh="";
				$rsh=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' quotationId="'.$quotationData['id'].'" and id = "'.$finalQuotTransfer['transferQuotationId'].'"'); 
				$transferQuotData=mysqli_fetch_array($rsh); 
						  
				$Ecity = getDestination($transferQuotData['destinationId']);
				
				if(strtotime($transferQuotData['fromDate']) == strtotime($transferQuotData['toDate'])){ 
					$transferDates = date('d M,Y',strtotime($transferQuotData['fromDate'])); 
				}else{ 
					$transferDates = date('d',strtotime($transferQuotData['fromDate']))."-".date('d M, Y',strtotime($transferQuotData['toDate'])); ; 
				}
				
				$d="";
				$d=GetPageRecord('*','vehicleMaster','id="'.$transferQuotData['vehicleId'].'"'); 
				$vehicleData=mysqli_fetch_array($d);
				$e="";
				$e=GetPageRecord('*','vehicleBrand','id="'.$vehicleData['brand'].'"'); 
				$vehicleBrandData=mysqli_fetch_array($e); 
				
				$rsh="";
				$rsh=GetPageRecord('*','finalquotationItinerary','serviceType="transfer" and confirmStatus=0 and supplierId="'.$supplierData['id'].'" and finalServiceId="'.$finalQuotTransfer['id'].'" and quotServiceId="'.$transferQuotData['id'].'" and serviceId="'.$transferData['id'].'" and quotationId="'.$quotationData['id'].'" ');   
				if(mysqli_num_rows($rsh) < 1){
					$namevalue ='serviceType="transfer",confirmStatus=0,supplierId="'.$supplierData['id'].'",finalServiceId="'.$finalQuotData['id'].'",quotServiceId="'.$transferQuotData['id'].'",serviceId="'.$transferData['id'].'",dayId=0,quotationId="'.$quotationData['id'].'",queryId="'.$quotationData['queryId'].'",startDate="'.$transferQuotData['fromDate'].'",endDate="'.$transferQuotData['toDate'].'",srn="'.$srno.'"';  
					$lastId = addlistinggetlastid('finalquotationItinerary',$namevalue); 
				}

				?>
				<div style="font-size:15px; font-weight:500; padding:0px; margin-bottom:5px; border:1px solid #ccc;position:relative;background-color: #f4f4f4;">
					<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
						<tbody>
						<tr>
						  <td width="50%"  bgcolor="#F4F4F4">
							<input type="hidden" value="<?php echo $finalQuotTransfer['id'];?>" id="transferfinalId<?php echo $transferQuotData['id']; ?>">
							<input type="hidden" value="<?php echo $transferData['id'];?>" id="transferId<?php echo $transferQuotData['id']; ?>">
						  Transfer:&nbsp;<?php echo strip($transferData['transferName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = getDestination($transferQuotData['destinationId']);  ?>&nbsp;)</td>
						  <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:5px; font-size:12px;"><?php echo $transferDates; ?></span></td>
						  <td width="33%" bgcolor="#F4F4F4">&nbsp;</td>
					  </tr>
					  
						  
						</tbody> 
					  </table>

		  </div> 	
				<?php
			}  
		}
		
		$b="";
		$b=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierData['id'].'" order by id asc'); 
		if(mysqli_num_rows($b) > 0){ 
			while($finalQuoteEntranceData=mysqli_fetch_array($b)){ 
				$d="";
				$d=GetPageRecord('*',_PACKAGE_BUILDER_ENTRANCE_MASTER_,' id="'.$finalQuoteEntranceData['entranceId'].'"');   
				$entranceData=mysqli_fetch_array($d);
				  
				$supplierId = $finalQuoteEntranceData['supplierId'];
				$entranceId = $entranceQuotData['entranceNameId'];
				 
				$rsh="";
				$rsh=GetPageRecord('*',_QUOTATION_ENTRANCE_MASTER_,' id="'.$finalQuoteEntranceData['entranceQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');  
				$entranceQuotData=mysqli_fetch_array($rsh); 
				
				if(strtotime($entranceQuotData['fromDate']) == strtotime($entranceQuotData['toDate'])){ 
					$entranceDates = date('d M,Y',strtotime($entranceQuotData['fromDate'])); 
				}else{ 
					$entranceDates = date('d',strtotime($entranceQuotData['fromDate']))."-".date('d M, Y',strtotime($entranceQuotData['toDate'])); ; 
				} 
				$Ecity = strip($entranceData['entranceCity']);	
				
				$rsh="";
				$rsh=GetPageRecord('*','finalquotationItinerary','serviceType="entrance" and confirmStatus=0 and supplierId="'.$supplierData['id'].'" and finalServiceId="'.$finalQuoteEntranceData['id'].'" and quotServiceId="'.$entranceQuotData['id'].'" and serviceId="'.$entranceData['id'].'" and quotationId="'.$quotationData['id'].'" ');   
				if(mysqli_num_rows($rsh) < 1){
					$namevalue ='serviceType="entrance",confirmStatus=0,supplierId="'.$supplierData['id'].'",finalServiceId="'.$finalQuoteEntranceData['id'].'",quotServiceId="'.$entranceQuotData['id'].'",serviceId="'.$entranceData['id'].'",dayId=0,quotationId="'.$quotationData['id'].'",queryId="'.$quotationData['queryId'].'",startDate="'.$entranceQuotData['fromDate'].'",endDate="'.$entranceQuotData['toDate'].'",srn="'.$srno.'"';  
					$lastId = addlistinggetlastid('finalquotationItinerary',$namevalue); 
				}	 
				?> 
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
					<tbody>
					  <tr>
					  <td width="50%"  bgcolor="#F4F4F4">
						<input type="hidden" value="<?php echo $finalQuoteEntranceData['id'];?>" id="entrancefinalId<?php echo $entranceQuotData['id']; ?>">
						<input type="hidden" value="<?php echo $entranceData['id'];?>" id="entranceId<?php echo $entranceQuotData['id']; ?>">
						Entrance:&nbsp;<?php echo strip($entranceData['entranceName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($entranceData['entranceCity']);  ?>&nbsp;)				  
					  </td>
					  <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:5px; font-size:12px;"><?php echo $entranceDates; ?></span></td>
					  <td width="33%" bgcolor="#F4F4F4">&nbsp;</td>
					  </tr>
					   
					</tbody> 
				  </table>
				 </div> 
				<?php
				}  
		} 
		
		$b="";
		$b=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierData['id'].'" order by id asc'); 
		if(mysqli_num_rows($b) > 0){ 

			while($finalQuoteActivityData=mysqli_fetch_array($b)){ 
				$d="";
				$d=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$finalQuoteActivityData['activityId'].'"');   
				$activityData=mysqli_fetch_array($d);
				$activityId = $activityData['id'];
 
				$rsh="";
				$rsh=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' id="'.$finalQuoteActivityData['activityQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');  
				$activityQuotData=mysqli_fetch_array($rsh); 
				
				if(strtotime($activityQuotData['fromDate']) == strtotime($activityQuotData['toDate'])){ 
					$activityDates = date('d M,Y',strtotime($activityQuotData['fromDate'])); 
				}else{ 
					$activityDates = date('d',strtotime($activityQuotData['fromDate']))."-".date('d M, Y',strtotime($activityQuotData['toDate'])); ; 
				} 
				$Ecity = strip($activityData['otherActivityCity']);
				
				$rsh="";
				$rsh=GetPageRecord('*','finalquotationItinerary','serviceType="activity" and confirmStatus=0 and supplierId="'.$supplierData['id'].'" and finalServiceId="'.$finalQuoteActivityData['id'].'" and quotServiceId="'.$activityQuotData['id'].'" and serviceId="'.$activityData['id'].'" and quotationId="'.$quotationData['id'].'" ');   
				if(mysqli_num_rows($rsh) < 1){
					$namevalue ='serviceType="activity",confirmStatus=0,supplierId="'.$supplierData['id'].'",finalServiceId="'.$finalQuoteActivityData['id'].'",quotServiceId="'.$activityQuotData['id'].'",serviceId="'.$activityData['id'].'",dayId=0,quotationId="'.$quotationData['id'].'",queryId="'.$quotationData['queryId'].'",startDate="'.$activityQuotData['fromDate'].'",endDate="'.$activityQuotData['toDate'].'",srn="'.$srno.'"';  
					$lastId = addlistinggetlastid('finalquotationItinerary',$namevalue); 
				}	 		 
				?> 
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
					<tbody>
					  <tr>
					  <td width="50%"  bgcolor="#F4F4F4">
						<input type="hidden" value="<?php echo $finalQuoteActivityData['id'];?>" id="activityfinalId<?php echo $activityQuotData['id']; ?>">
						<input type="hidden" value="<?php echo $activityData['id'];?>" id="activityId<?php echo $activityQuotData['id']; ?>">
						Activity:&nbsp;<?php echo strip($activityData['otherActivityName']);  ?>&nbsp;(&nbsp;<?php echo $hcity = strip($activityData['otherActivityCity']);  ?>&nbsp;)				  
					  </td>
					  <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:5px; font-size:12px;"><?php echo $activityDates; ?></span></td>
					  <td width="33%" bgcolor="#F4F4F4">&nbsp;</td>
					  </tr> 
					   
					</tbody> 
				  </table>
				 </div> 
				<?php
				}  
		} 
		
		$b="";
		$b=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierData['id'].'" order by id asc'); 
		if(mysqli_num_rows($b) > 0){ 
			while($finalQuoteTrainData=mysqli_fetch_array($b)){ 
				$d="";
				$d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$finalQuoteTrainData['trainId'].'"');   
				$trainData=mysqli_fetch_array($d);
				$trainId = $trainData['id'];
 
				$rsh="";
				$rsh=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' id="'.$finalQuoteTrainData['trainQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');  
				$trainQuotData=mysqli_fetch_array($rsh); 
				
				if(strtotime($trainQuotData['fromDate']) == strtotime($trainQuotData['toDate'])){ 
					$trainDates = date('d M,Y',strtotime($trainQuotData['fromDate'])); 
				}else{ 
					$trainDates = date('d',strtotime($trainQuotData['fromDate']))."-".date('d M, Y',strtotime($trainQuotData['toDate'])); ; 
				} 
				$Ecity = getDestination($trainQuotData['destinationId']);		 
				
				$rsh="";
				$rsh=GetPageRecord('*','finalquotationItinerary','serviceType="train" and confirmStatus=0 and supplierId="'.$supplierData['id'].'" and finalServiceId="'.$finalQuoteTrainData['id'].'" and quotServiceId="'.$trainQuotData['id'].'" and serviceId="'.$trainData['id'].'" and quotationId="'.$quotationData['id'].'" ');   
				if(mysqli_num_rows($rsh) < 1){
					$namevalue ='serviceType="train",confirmStatus=0,supplierId="'.$supplierData['id'].'",finalServiceId="'.$finalQuoteTrainData['id'].'",quotServiceId="'.$trainQuotData['id'].'",serviceId="'.$trainData['id'].'",dayId=0,quotationId="'.$quotationData['id'].'",queryId="'.$quotationData['queryId'].'",startDate="'.$trainQuotData['fromDate'].'",endDate="'.$trainQuotData['toDate'].'",srn="'.$srno.'"';  
					$lastId = addlistinggetlastid('finalquotationItinerary',$namevalue); 
				}	
				?> 
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
					<tbody>
					  <tr>
					  <td width="50%"  bgcolor="#F4F4F4">
						<input type="hidden" value="<?php echo $finalQuoteTrainData['id'];?>" id="trainfinalId<?php echo $trainQuotData['id']; ?>">
						<input type="hidden" value="<?php echo $trainData['id'];?>" id="trainId<?php echo $trainQuotData['id']; ?>">
						Train:&nbsp;<?php echo strip($trainData['trainName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
					  </td>
					  <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:5px; font-size:12px;"><?php echo $trainDates; ?></span></td>
					  <td width="33%" bgcolor="#F4F4F4">&nbsp;</td>
					  </tr>
					   
					</tbody> 
				  </table>
				 </div> 
				<?php
				}  
		} 
		
		$b="";
		$b=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierData['id'].'" order by id asc'); 
		if(mysqli_num_rows($b) > 0){ 
			while($finalQuoteFlightData=mysqli_fetch_array($b)){ 
				$d="";
				$d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$finalQuoteFlightData['flightId'].'"');   
				$flightData=mysqli_fetch_array($d);
				$flightId = $flightData['id'];
 
				$rsh="";
				$rsh=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' id="'.$finalQuoteFlightData['flightQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');  
				$flightQuotData=mysqli_fetch_array($rsh); 
				
				if(strtotime($flightQuotData['fromDate']) == strtotime($flightQuotData['toDate'])){ 
					$flightDates = date('d M,Y',strtotime($flightQuotData['fromDate'])); 
				}else{ 
					$flightDates = date('d',strtotime($flightQuotData['fromDate']))."-".date('d M, Y',strtotime($flightQuotData['toDate'])); ; 
				} 
				$Ecity = getDestination($flightQuotData['destinationId']);		 
				
				$rsh="";
				$rsh=GetPageRecord('*','finalquotationItinerary','serviceType="flight" and confirmStatus=0 and supplierId="'.$supplierData['id'].'" and finalServiceId="'.$finalQuoteFlightData['id'].'" and quotServiceId="'.$trainQuotData['id'].'" and serviceId="'.$flightData['id'].'" and quotationId="'.$quotationData['id'].'" ');   
				if(mysqli_num_rows($rsh) < 1){
					$namevalue ='serviceType="flight",confirmStatus=0,supplierId="'.$supplierData['id'].'",finalServiceId="'.$finalQuoteFlightData['id'].'",quotServiceId="'.$flightQuotData['id'].'",serviceId="'.$flightData['id'].'",dayId=0,quotationId="'.$quotationData['id'].'",queryId="'.$quotationData['queryId'].'",startDate="'.$flightQuotData['fromDate'].'",endDate="'.$flightQuotData['toDate'].'",srn="'.$srno.'"';  
					$lastId = addlistinggetlastid('finalquotationItinerary',$namevalue); 
				}
				?> 
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
					<tbody>
					  <tr>
					  <td width="50%"  bgcolor="#F4F4F4">
						<input type="hidden" value="<?php echo $finalQuoteFlightData['id'];?>" id="flightfinalId<?php echo $flightQuotData['id']; ?>">
						<input type="hidden" value="<?php echo $flightData['id'];?>" id="flightId<?php echo $flightQuotData['id']; ?>">
						Flight:&nbsp;<?php echo strip($flightData['flightName']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
					  </td>
					  <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:5px; font-size:12px;"><?php echo $flightDates; ?></span></td>
					  <td width="33%" bgcolor="#F4F4F4">&nbsp;</td>
					  </tr>
					   
					</tbody> 
				  </table>
				 </div> 
				<?php
				}  
		} 
		 
		$b="";
		$b=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierData['id'].'" order by id asc'); 
		if(mysqli_num_rows($b) > 0){ 
			while($finalQuoteGuideData=mysqli_fetch_array($b)){ 
				$d="";
				$d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$finalQuoteGuideData['guideId'].'"');   
				$guideData=mysqli_fetch_array($d);
				$guideId = $guideData['id'];
 
				$rsh="";
				$rsh=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' id="'.$finalQuoteGuideData['guideQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');  
				$guideQuotData=mysqli_fetch_array($rsh); 
				
				if(strtotime($guideQuotData['fromDate']) == strtotime($guideQuotData['toDate'])){ 
					$guideDates = date('d M, Y',strtotime($guideQuotData['fromDate'])); 
				}else{ 
					$guideDates = date('d',strtotime($guideQuotData['fromDate']))."-".date('d M, Y',strtotime($guideQuotData['toDate'])); ; 
				} 
				$Ecity = getDestination($guideQuotData['destinationId']);
				
				$rsh="";
				$rsh=GetPageRecord('*','finalquotationItinerary','serviceType="guide" and confirmStatus=0 and supplierId="'.$supplierData['id'].'" and finalServiceId="'.$finalQuoteGuideData['id'].'" and quotServiceId="'.$guideQuotData['id'].'" and serviceId="'.$guideData['id'].'" and quotationId="'.$quotationData['id'].'" ');   
				if(mysqli_num_rows($rsh) < 1){
					$namevalue ='serviceType="guide",confirmStatus=0,supplierId="'.$supplierData['id'].'",finalServiceId="'.$finalQuoteGuideData['id'].'",quotServiceId="'.$guideQuotData['id'].'",serviceId="'.$guideData['id'].'",dayId=0,quotationId="'.$quotationData['id'].'",queryId="'.$quotationData['queryId'].'",startDate="'.$guideQuotData['fromDate'].'",endDate="'.$guideQuotData['toDate'].'",srn="'.$srno.'"';  
					$lastId = addlistinggetlastid('finalquotationItinerary',$namevalue); 
				}		 
				?> 
				<div style="font-size:15px; font-weight:500; padding:0px;margin-bottom:5px; border:1px solid #ccc; position:relative;background-color: #f4f4f4;">
				<table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC"  >
					<tbody>
					  <tr>
					  <td width="50%"  bgcolor="#F4F4F4">
						<input type="hidden" value="<?php echo $finalQuoteGuideData['id'];?>" id="guidefinalId<?php echo $guideQuotData['id']; ?>">
						<input type="hidden" value="<?php echo $guideData['id'];?>" id="guideId<?php echo $guideQuotData['id']; ?>">
						Guide:&nbsp;<?php echo strip($guideData['name']);  ?>&nbsp;(&nbsp;<?php echo $Ecity;  ?>&nbsp;)				  
					  </td>
					  <td width="16%"  bgcolor="#F4F4F4"><span style="margin-bottom:5px; font-size:12px;"><?php echo $guideDates; ?></span></td>
					  <td width="33%" bgcolor="#F4F4F4">&nbsp;</td>
					  </tr>
					   
					</tbody> 
				  </table>
				 </div> 
				<?php
				}  

			} 
		
		?>
		</td>
		</tr> 
		<tr>
			<td colspan="4" align="left" valign="middle">				
				<a onclick="alertspopupopen('action=finalquote&queryId=<?php echo encode($quotationData['queryId']); ?>&quotationId=<?php echo $quotationData['id']; ?>&o=2','1000px','auto');"><input type="button" name="Cancel" value="  Back  " class="bluembutton"  ></a>
			<input type="button" name="Submit" value="   Send Mail   " class="bluembutton"  onclick="alert('Sent.');"> 
		</td>
		</tr>
		
	</tbody>
</table>	
<?php 	  
}

?>
