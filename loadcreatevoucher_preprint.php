<?php
include "inc.php"; 
$module = $_REQUEST['module'];
$rs=''; 
$rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$_REQUEST['quotationId'].'" and status=1 '); 
$quotationData=mysqli_fetch_array($rs);
$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$pax = ($quotationData['adult']+$quotationData['child']);
$room = ($quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']);

$costType = $quotationData['costType'];
$discountType= $quotationData['discountType'];
$discountTax = $quotationData['discount'];

//slab Date
$slabSql="";
$slabSql=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'" and status=1'); 
if(mysqli_num_rows($slabSql) > 0 ){
	$slabsData=mysqli_fetch_array($slabSql);
	$slabId = $slabsData['id']; 
	$dfactor = $slabsData['dividingFactor']; 
}

// query data 
$rs=''; 
$rs=GetPageRecord('*',_QUERY_MASTER_,'id="'.$queryId.'"'); 
$resultpage=mysqli_fetch_array($rs); 

$tourId  = makeQueryTourId($resultpage['id']);
$leadPaxName  = $resultpage['leadPaxName'];
$bookingId = makeQueryId($resultpage['id']);
$queryfromDate=$resultpage['fromDate']; 
 
?> 
<div style="position:relative;">  
<!-- style="padding: 40px;background-color: #fff;width: 800px;" -->
<div class="main-container" >
<?php  
//supplier wise voucher loop 
// and status=3
$fianlSuppQuery="";
$fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$quotationData['id'].'" and deletestatus=0 group by supplierId order by id asc'); 
if(mysqli_num_rows($fianlSuppQuery)>0){
while($supplierStatusData=mysqli_fetch_array($fianlSuppQuery)){

	if ($module=='ClientVoucher'){
		if($resultpage['clientType']=='1'){
			$ad=GetPageRecord('*',_CORPORATE_MASTER_,' id="'.$resultpage['companyId'].'" order by id desc');  
			$suppData=mysqli_fetch_array($ad);

			$rsss=GetPageRecord('*','contactPersonMaster',' corporateId="'.$suppData['id'].'" and contactPerson!="" and deletestatus=0 order by id asc'); 
			$resListing=mysqli_fetch_array($rsss);
			
			$agentName = $suppData['name'];
			$contactPerson = $resListingp['contactPerson'];
			$suppagentPone = decode($resListing['phone']);
			$suppagentEmail = decode($resListing['email']);

			$rssupad=GetPageRecord('*','addressMaster',' addressParent="'.$suppData['id'].'" and addressType="corporate" order by id asc');
			$supplierAddData=mysqli_fetch_array($rssupad);
		}
		if($resultpage['clientType']=='2'){
			$ad=GetPageRecord('*',_CONTACT_MASTER_,' id="'.$resultpage['companyId'].'" order by id desc');  
			$suppData=mysqli_fetch_array($ad);

			$rsss=GetPageRecord('*',_PHONE_MASTER_,' masterId="'.$suppData['id'].'" and sectionType="contacts" '); 
			$resListingp=mysqli_fetch_array($rsss);

			$rssupad=GetPageRecord('*',_EMAIL_MASTER_,' masterId="'.$suppData['id'].'" and sectionType="contacts" '); 
			$emailData=mysqli_fetch_array($rssupad);

			$rssupad3=GetPageRecord('*','nameTitleMaster',' id="'.$suppData['contacttitleId'].'" '); 
			$nameData=mysqli_fetch_array($rssupad3);

			
			$agentName = ucfirst($nameData['name']).' '.ucfirst($suppData['firstName']).' '.ucfirst($suppData['lastName']);
			$contactPerson = $suppData['name'];
			$suppagentPone = $resListingp['phoneNo'];
			$suppagentEmail = $emailData['email'];
			// $supplierAddData['gstn'] = '';
			$supplierAddData['address'] = $suppData['addressInfo'];
		} 
	} 

   
	$qIQuery2C='';  
 	//serviceId in ( select id from finalQuote where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or 
	$qIQuery2C=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) ) group by startDate order by startDate asc');
	if(mysqli_num_rows($qIQuery2C) > 0){
	 	// add or update voucher details
		$voucherQuery="";
		$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusData['id'].'" and serviceType="other" and serviceId=0 and quotationId="'.$quotationId.'"'); 
		if(mysqli_num_rows($voucherQuery)<1){
			$namevalue ='quotationId="'.$quotationId.'",supplierStatusId="'.$supplierStatusData['id'].'",serviceType="other",serviceId=0';
			$voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);

			// get data
			$voucherQuery2=GetPageRecord('*','voucherDetailsMaster','id="'.$voucherId.'" '); 
			$voucherDetailData = mysqli_fetch_array($voucherQuery2);
			$voucherDate  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
		} else{
			$voucherDetailData = mysqli_fetch_array($voucherQuery);
			$voucherId  = $voucherDetailData['id'];	
			$voucherDate  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
		} 
	 	if($module=='ClientVoucher'){
			$ADStatus = $voucherDetailData['cli_ADStatus'];
		 	$voucherNotes = $voucherDetailData['cli_voucherNotes'];
		 	$billInstYes = $voucherDetailData['cli_billInstYes'];
		 	$billingInstructions = $voucherDetailData['cli_billingInstructions'];

			$ADStatus2 = $voucherDetailData['cli_ADStatus2'];
		 	$voucherNotes2 = $voucherDetailData['cli_voucherNotes2'];
		 	$billInstYes2 = $voucherDetailData['cli_billInstYes2'];
		 	$billingInstructions2 = $voucherDetailData['cli_billingInstructions2'];
		}else{
			$ADStatus = $voucherDetailData['sup_ADStatus'];
		 	$billInstYes = $voucherDetailData['sup_billInstYes'];
		 	$voucherNotes = $voucherDetailData['sup_voucherNotes'];
		 	$billingInstructions = $voucherDetailData['sup_billingInstructions'];

			$ADStatus2 = $voucherDetailData['sup_ADStatus'];
		 	$billInstYes2 = $voucherDetailData['sup_billInstYes'];		 	
		 	$voucherNotes2 = $voucherDetailData['sup_voucherNotes'];
		 	$billingInstructions2 = $voucherDetailData['sup_billingInstructions'];
		} 
		$showVocherNum = generateVoucherNumber($voucherId,$module,strtotime($queryfromDate));	
	 	$suppStatusId_cnt = $supplierStatusData['id'];
	 	$supplierStatusId = $supplierStatusData['id']; 
		?>
		<!--All services vouchers lists except hotel-->
		<div class="sub-container" style="border:1px dashed #ddd;padding:10px;"  id="mailSectionArea<?php echo strip($supplierStatusData['id']);?>">
		<br><br><br><br><br><br><br><br><br><br><br>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr><td> 
				<!--logo block removed--> 
				<!--address block-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td width="78%" valign="top">
							<table>
								<tr>
									<td align="left" style="font-size: 16px;">
										<strong>To:&nbsp;<?php echo ucfirst($agentName); ?></strong>
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Address&nbsp;:&nbsp;</strong><?php echo strip($supplierAddData['address']); ?>
									</td>
								</tr>
								<tr>
									<td align="left" >
									<?php if($contactPerson!=''){ ?>
										<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo strip($contactPerson); ?>&nbsp;&nbsp;&nbsp;&nbsp;
									<?php } ?>
										<strong>Phone&nbsp;:&nbsp;</strong><?php  echo $suppagentPone; ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>Email&nbsp;:&nbsp;</strong><?php  echo $suppagentEmail; ?>
									</td>
								</tr>
								<tr>
									<td align="left" ><strong>In favour of&nbsp;:&nbsp;</strong><span ><?php 
									$otherpxQuery=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$quotationId.'" and supplierStatusId="'.$supplierStatusId.'"');
									$ttlOthPx = mysqli_num_rows($otherpxQuery);	
									if($ttlOthPx>0){ 
										$cnt=1;	
										while($otherpaxdata=mysqli_fetch_array($otherpxQuery)){
											echo ucfirst($otherpaxdata['otherGuestName']); 
											if($ttlOthPx>$cnt && ($ttlOthPx-1)!=$cnt){ echo ",&nbsp;&nbsp;";}
											if(($ttlOthPx-1)==$cnt){ echo " and&nbsp;";}
											$cnt++;
										}
										?></span>
									<?php }else{ ?>
									<span ><?php echo strip($resultpage['leadPaxName']);  ?></span>
									<?php } ?>
									</td>
								</tr>
							</table> 
						</td>
						<td width="22%" valign="top">
							<table>
								<tr>
									<td  align="left">
										<strong>Tour&nbsp;ID&nbsp;:&nbsp;</strong><?php echo $tourId; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;No&nbsp;:&nbsp;</strong><?php echo $showVocherNum; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;Date&nbsp;:&nbsp;</strong><?php 
										if($voucherDate!='1970-01-01 00:00:00' && $voucherDate!='0000-00-00 00:00:00' && $voucherDate!=''){
											echo date('d/m/Y', strtotime($voucherDate)); 
										}else{ 
											echo date('d/m/Y',strtotime($fromDate)); 
										} ?> 
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $pax; ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<br>
				<!-- Services Date -->
				<table width="100%" border="0" cellpadding="1" cellspacing="0" >
					<tr> 
						<td width="100%"><strong>Please provide the services as per the following.</strong></td> 
					</tr>
				</table>    
				<!-- Service date wise list -->
				<table width="100%" border="0" cellspacing="0" borderColor="#ccc" cellpadding="0" style="font-size:13px;"><?php  
			 		$cnt=0;
			 		$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) ) group by startDate order by startDate asc');
					while($finalIt_Data2=mysqli_fetch_array($qIQuery2)){ 
						if($cnt == 0){
							$startDate=$finalIt_Data2['startDate'];
						}
						$endDate = $finalIt_Data2['startDate'];

						// get data
						$destQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$finalIt_Data2['quotationId'].'" and srdate="'.$finalIt_Data2['startDate'].'" '); 
						$dayDData = mysqli_fetch_array($destQuery);
						$cityId = $dayDData['cityId'];
						if($cnt != 0){
						} ?><tr><td width="10%"><div  style="width: 100px"><?php echo date('d M Y',strtotime($finalIt_Data2['startDate'])); ?></div></td>
						<?php
						//serial wise loop
						$serviceDetails = '';
						$qIQuery=''; 
						$qIQuery=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) ) and startDate="'.$finalIt_Data2['startDate'].'" order by srn asc');
					 	while($finalIt_Data=mysqli_fetch_array($qIQuery)){
			 
							if($finalIt_Data['serviceType'] == 'transfer' || $finalIt_Data['serviceType'] == 'transportation'){  
								$transferQuery='';     
								$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" order by fromDate asc ');  
								while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
									
									$transferFlag = 1;
									$c="";  
									$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTransfer['transferId'].'"'); 
									$transferData=mysqli_fetch_array($c);
									
									$d=GetPageRecord('*','quotationTransferMaster','id="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
									$transferQuoteData=mysqli_fetch_array($d);
									
			 						$c="";
									$c=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
									$TimeData=mysqli_fetch_array($c);	
									if(strtotime($TimeData['arrivalTime'])=='1621036800' && strtotime($TimeData['dropTime'])=='1621036800' || strtotime($TimeData['arrivalTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($TimeData['arrivalTime']));
										$endTime24Set = date('H:i',strtotime($TimeData['dropTime']));
									} 
									 
									$d="";
									$d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteTransfer['vehicleModelId'].'"'); 
									$vehicleData=mysqli_fetch_array($d);
									
									$e="";
									$e=GetPageRecord('*','vehicleBrand','id="'.$vehicleData['brand'].'"'); 
									$vehicleBrandData=mysqli_fetch_array($e); 


									$serviceDetails .= ucfirst($transferData['transferName'])." | ".$vehicleBrandData['name']." | ".$vehicleData['model']; 
									$serviceDetails .= " + ";

								}
							}   

							// Ferry Voucher start 
							if($finalIt_Data['serviceType'] == 'ferry'){ 
								$ferryQuery='';   
								$ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteFerry=mysqli_fetch_array($ferryQuery)){
									 
									$ccc="";
									 $ccc=GetPageRecord('*','quotationFerryMaster','  id="'.$finalQuoteFerry['ferryQuotationId'].'"'); 
									$TimeData=mysqli_fetch_array($ccc);	

									$dddd="";
									 $dddd=GetPageRecord('*','ferryClassMaster','  id="'.$TimeData['ferryClass'].'"'); 
									$ferryClassname=mysqli_fetch_array($dddd);	


									$dd="";
									$dd=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerry['ferryId'].'"'); 
									$ferryData=mysqli_fetch_array($dd);

									$serviceDetails .= ucfirst($ferryData['name']).' | '.strip($ferryClassname['name']);
									$serviceDetails .= " + ";

									 
								 }  
							} 

							if($finalIt_Data['serviceType'] == 'entrance'){ 
								$entranceQuery='';   
								$entranceQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteEntrance=mysqli_fetch_array($entranceQuery)){
									 
									//quotationId = "'.$quotationData['id'].'" and
									$c="";
			 						$c=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$finalQuoteEntrance['entranceQuotationId'].'"'); 
									$TimeData=mysqli_fetch_array($c);	
									if(strtotime($TimeData['startTime'])=='1621036800' && strtotime($TimeData['endTime'])=='1621036800' || strtotime($TimeData['startTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($TimeData['startTime']));
										$endTime24Set = date('H:i',strtotime($TimeData['endTime']));
									} 

									$c="";
									$c=GetPageRecord('*','packageBuilderEntranceMaster','id="'.$finalQuoteEntrance['entranceId'].'"'); 
									$entranceData=mysqli_fetch_array($c);

									$serviceDetails .= ucfirst($entranceData['entranceName']); 
									$serviceDetails .= " + ";
								 }  
							}
						 	
						 	if($finalIt_Data['serviceType'] == 'activity'){
							
								$activityQuery='';   
								$activityQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteActivity=mysqli_fetch_array($activityQuery)){

									$c="";
									$c=GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$finalQuoteActivity['activityId'].'"');
									$activityData=mysqli_fetch_array($c);
			 						
									//quotationId = "'.$quotationData['id'].'" and
									$c="";
									$c=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$finalQuoteActivity['activityQuotationId'].'"');
									$TimeData=mysqli_fetch_array($c);
									if(strtotime($TimeData['startTime'])=='1621036800' && strtotime($TimeData['endTime'])=='1621036800' || strtotime($TimeData['startTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($TimeData['startTime']));
										$endTime24Set = date('H:i',strtotime($TimeData['endTime']));
									} 
									$serviceDetails .= ucfirst($activityData['otherActivityName']);
									$serviceDetails .= " + ";

									$cnt++;
								}   
							}
						 
							if($finalIt_Data['serviceType'] == 'train'){ 
								$trainFlag=1;
								$trainQuery='';   
								$trainQuery=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteTrains=mysqli_fetch_array($trainQuery)){
								 
									$c=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$finalQuoteTrains['trainId'].'"'); 
									$trainData=mysqli_fetch_array($c);	 
			 						 
									// echo $finalQuoteTrains['trainQuotationId']."sssssss";
									$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
									if(trim($finalQuoteTrains['departureTime'])=='' || trim($finalQuoteTrains['arrivalTime'])==''){
										$departureTime = $arrivalTime ='';
									}else{
										$departureTime = date('H:i',strtotime($finalQuoteTrains['departureTime']));
										$arrivalTime = date('H:i',strtotime($finalQuoteTrains['arrivalTime']));
									}
									if(trim($finalQuoteTrains['departureDate'])!='0000-00-00 00:00:00'){
										$departureDate = date('j M Y',strtotime($finalQuoteTrains['departureDate']));
									} 
									if(trim($finalQuoteTrains['arrivalDate'])!='0000-00-00 00:00:00'){
										$arrivalDate = date('j M Y',strtotime($finalQuoteTrains['arrivalDate']));
									} 
									 
									$arrivalTo = getDestination($finalQuoteTrains['arrivalTo']);
									$departureFrom = getDestination($finalQuoteTrains['departureFrom']);
									$trainName = $trainData['trainName'];
									$trainNumber = $finalQuoteTrains['trainNumber']; 
									$trainClass = $finalQuoteTrains['trainClass'];
									
									if($finalQuoteTrains['journeyType'] == 'overnight'){
										$journeyType = 'Overnight';
									}else{
										$journeyType = 'Day';
									}

									$serviceDetails .= "Train : ".ucfirst($trainName).'/'.$trainNumber.'/'.$trainClass."/".$journeyType;  
									$serviceDetails .= " + ";
											
								} 
							} 
						 	
						 	if($finalIt_Data['serviceType'] == 'flight'){ 
						 		$flightFlag=1;
								$flightQuery='';   
								$flightQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							 	 
								while($finalQuoteFlights=mysqli_fetch_array($flightQuery)){
								 
									$c=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightId'].'"'); 
									$flightData=mysqli_fetch_array($c);	 
									
									if(strtotime($finalQuoteFlights['arrivalTime'])=='1621036800' && strtotime($finalQuoteFlights['departureTime'])=='1621036800' || strtotime($finalQuoteFlights['arrivalTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
										$endTime24Set = date('H:i',strtotime($finalQuoteFlights['departureTime']));
									}  



									$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
									if(trim($finalQuoteFlights['departureTime'])=='' || trim($finalQuoteFlights['arrivalTime'])==''){
										$departureTime = $arrivalTime ='';
									}else{
										$departureTime = date('H:i',strtotime($finalQuoteFlights['departureTime']));
										$arrivalTime = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
									}
									if(trim($finalQuoteFlights['departureDate'])!='0000-00-00 00:00:00'){
										$departureDate = date('j M Y',strtotime($finalQuoteFlights['departureDate']));
									} 
									if(trim($finalQuoteFlights['arrivalDate'])!='0000-00-00 00:00:00'){
										$arrivalDate = date('j M Y',strtotime($finalQuoteFlights['arrivalDate']));
									} 
									 
									$arrivalTo = getDestination($finalQuoteFlights['arrivalTo']);
									$departureFrom = getDestination($finalQuoteFlights['departureFrom']);
									$flightName = $flightData['flightName'];
									$flightNumber = $finalQuoteFlights['flightNumber']; 
									$flightClass = $finalQuoteFlights['flightClass'];
									 
									$serviceDetails .= "Flight : ".ucfirst($flightName).'/'.$flightNumber.'/'.$flightClass;  
									$serviceDetails .= " + ";
	 
								}  
							}

						 	if($finalIt_Data['serviceType'] == 'mealplan'){
								$mealPlanQuery='';   
								$mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteMealPlan=mysqli_fetch_array($mealPlanQuery)){		
									$serviceDetails .= "".ucfirst($finalQuoteMealPlan['mealPlanName']);  
									$serviceDetails .= " + ";
								}  
							} 
								
							if($finalIt_Data['serviceType'] == 'additional'){
								$additionalQuery='';   
								$additionalQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
						 	 
								while($finalQuoteadditionalD=mysqli_fetch_array($additionalQuery)){
								
			 						$groupCost = $finalQuoteadditionalD['groupCost'];
									$c=GetPageRecord('*','extraQuotation','id="'.$finalQuoteadditionalD['additionalId'].'"'); 
									$additionalData=mysqli_fetch_array($c);	  


									$serviceDetails .= "".ucfirst($additionalData['name']);  
									$serviceDetails .= " + ";
								}  
							}  

						 	if($finalIt_Data['serviceType'] == 'guide'){
								 
								$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc ');  
						 		while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){
							 
									$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
									$guideData=mysqli_fetch_array($c);	 
			 						
			 						$serviceDetails .= "".ucfirst($guideData['name']);   
			 						$serviceDetails .= " + ";
								}
							}

						}
						$cnt++;

						?><td colspan="3"> : <?php echo getDestination($cityId)." - ".rtrim($serviceDetails,' + ');?></td>
						</tr>
						<?php
					} 
					?>  
					<!-- end of the services loop from final tables -->
				</table>
				<!-- Arrival Departure for hotel and transfer-->
				<style type="text/css">
					@media print
					{    
					    .removeEle{
					        display: none !important;
					    } 
						table{
							border: 0px solid #fff;
							border-collapse: collapse; 

						}
						input[type=text], input[type=date]{
							width:94%;
						}
					    input, textarea{
							border: 0px solid;
    						border-color: #fff;
							outline: none;		        
					    }
					}
					table{
						border-collapse: collapse; 
					}
					.main-container input[type=text],.main-container input[type=date]{
						width:94%;
					}
					.main-container input, .main-container textarea{
						border: 1px solid;
						border-color: #ccc;
						padding: 3px;
						font-size: 12px;
						outline: none;		        
					}
					.w100{ width: 99%; }
					.hidediv{
				        display: none !important;
				    }
				</style>
				<br>
				<!-- Arrival Departure for hotel and transfer-->
 				<table  border="0" cellpadding="2" cellspacing="0" class="removeEle">
 					<tr>
						<td><strong>Arrival/Departure Details</strong></td>
						<td ><lable onclick="willPrintNotPrint1(1,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus ?>');"  ><input type="radio" name="willPrint1<?php echo $suppStatusId_cnt;?>" id="willPrint1<?php echo $suppStatusId_cnt;?>" value="1" style="display:inline-block;" <?php if ($ADStatus==1) { echo "checked";} ?>>&nbsp;Will&nbsp;Print</lable></td>
						<td ><lable onclick="willPrintNotPrint1(0,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus ?>');" ><input type="radio" name="willPrint1<?php echo $suppStatusId_cnt;?>" id="willNotPrint1<?php echo $suppStatusId_cnt;?>" value="0" style="display:inline-block;" <?php if ($ADStatus==0) { echo "checked";} ?>>&nbsp;Will&nbsp;Not&nbsp;Print</lable></td>
					</tr>
				</table>
				
				<table  border="0" borderColor="#ccc" cellpadding="2" cellspacing="0"  class="Arrival_DepartureDiv1<?php echo $suppStatusId_cnt;?> <?php if ($ADStatus==0) { echo "removeEle hidediv";} ?>" >
					<tr>
						<td align="left" valign="middle" width="15%">
							<strong>Arrival On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_arrival_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("d/m/Y", strtotime($fromDate)); }   ?> 
						</td>
						<td align="left" valign="middle"  >
							<strong>From&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_by_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>
						</td> 
					</tr>
					<tr>
						<td align="left" valign="middle">
							<strong>Departure On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_departure_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("d/m/Y", strtotime($toDate));}   ?>
						</td>
						<td align="left" valign="middle">
							<strong>To&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_by_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>
						</td>
					</tr>
				</table> 
				<!-- Notes and Billing INstructions --> 
				<br>
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr align="left" valign="top">
						<td colspan="3">
							<input type="hidden" name="voucherDate<?php echo $suppStatusId_cnt;?>" id="voucherDate<?php echo $suppStatusId_cnt;?>" value="<?php echo $voucherDate; ?>">
							<input type="hidden" name="voucherNumber<?php echo $suppStatusId_cnt;?>" id="voucherNumber<?php echo $suppStatusId_cnt;?>" value="<?php echo $showVocherNum; ?>">
							<strong>Noted to be printed on voucher</strong>
							<textarea id="voucherNotes1<?php echo $suppStatusId_cnt;?>"   class="w100" ><?php if(!empty($voucherNotes)){ echo strip($voucherNotes); }else{ 
									echo ''; 
								} ?></textarea> 
								<br>
						</td>
					</tr>
					<tr align="left" valign="top" class="removeEle">
						<td colspan="3"><lable onclick="billInstYes('<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>')" ><input type="checkbox" value="0"  id="billInstYes1<?php echo $suppStatusId_cnt;?>" style="display: inline-block;" <?php if($billInstYes==1){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;Billing&nbsp;Instruction</lable>
						</td>
					</tr>
					<tr align="left" valign="top" class="<?php if($billInstYes==1){ ?> removeEle hidediv <?php } ?>billInstYesDiv1<?php echo $suppStatusId_cnt;?>">
						<td colspan="3">
							<strong>Billing&nbsp;Instructions&nbsp;</strong><br>
							<textarea id="billingInstructions1<?php echo $suppStatusId_cnt;?>"  class="w100"><?php if(!empty($billingInstructions) or $billInstYes==0){ echo strip($billingInstructions); }else{ echo 'Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.'; } ?></textarea>
						</td>
					</tr>
				</table>
			</td>
			</tr>
		</table>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr><td> 
				<!--logo block removed-->
				
				<!--address block-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td width="78%" valign="top">
							<table>
								<tr>
									<td align="left" style="font-size: 16px;">
										<strong>To:&nbsp;<?php echo ucfirst($agentName); ?></strong>
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Address&nbsp;:&nbsp;</strong><?php echo strip($supplierAddData['address']); ?>
									</td>
								</tr>
								<tr>
									<td align="left" >
									<?php if($contactPerson!=''){ ?>
										<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo strip($contactPerson); ?>&nbsp;&nbsp;&nbsp;&nbsp;
									<?php } ?>
										<strong>Phone&nbsp;:&nbsp;</strong><?php  echo $suppagentPone; ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>Email&nbsp;:&nbsp;</strong><?php  echo $suppagentEmail; ?>
									</td>
								</tr>
								<tr>
									<td align="left" ><strong>In favour of&nbsp;:&nbsp;</strong><span ><?php 
									$otherpxQuery=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$quotationId.'" and supplierStatusId="'.$supplierStatusId.'"');
									$ttlOthPx = mysqli_num_rows($otherpxQuery);	
									if($ttlOthPx>0){ 
										$cnt=1;	
										while($otherpaxdata=mysqli_fetch_array($otherpxQuery)){
											echo ucfirst($otherpaxdata['otherGuestName']); 
											if($ttlOthPx>$cnt && ($ttlOthPx-1)!=$cnt){ echo ",&nbsp;&nbsp;";}
											if(($ttlOthPx-1)==$cnt){ echo " and&nbsp;";}
											$cnt++;
										}
										?></span>
									<?php }else{ ?>
									<span ><?php echo strip($resultpage['leadPaxName']);  ?></span>
									<?php } ?>
									</td>
								</tr>
							</table>
						</td>
						<td width="22%" valign="top">
							<table>
								<tr>
									<td  align="left">
										<strong>Tour&nbsp;ID&nbsp;:&nbsp;</strong><?php echo $tourId; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;No&nbsp;:&nbsp;</strong><?php echo $showVocherNum; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;Date&nbsp;:&nbsp;</strong><?php 
										if($voucherDate!='1970-01-01 00:00:00' && $voucherDate!='0000-00-00 00:00:00' && $voucherDate!=''){
											echo date('d/m/Y', strtotime($voucherDate)); 
										}else{ 
											echo date('d/m/Y',strtotime($fromDate)); 
										} ?> 
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $pax; ?>
									</td>
								</tr> 
							</table>
						</td>
					</tr>
				</table>
				<br>
				<!-- Services Date -->
				<table width="100%" border="0" cellpadding="1" cellspacing="0" >
					<tr> 
						<td width="100%"><strong>Please provide the services as per the following.</strong></td> 
					</tr>
				</table>    
				<!-- Service date wise list -->
				<table width="100%" border="0" cellspacing="0" borderColor="#ccc" cellpadding="0" style="font-size:13px;"><?php  
			 		$cnt=0;
			 		$qIQueryD2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) ) group by startDate order by startDate asc');
					while($finalIt_DataD2=mysqli_fetch_array($qIQueryD2)){
						if($cnt == 0){
							$startDate=$finalIt_DataD2['startDate'];
						}
						$endDate = $finalIt_DataD2['startDate'];

						// get data
						$destQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$finalIt_DataD2['quotationId'].'" and srdate="'.$finalIt_DataD2['startDate'].'" '); 
						$dayDData = mysqli_fetch_array($destQuery);
						$cityId = $dayDData['cityId'];
						if($cnt != 0){ 
						} ?><tr><td width="10%"><div  style="width: 100px"><?php echo date('d M Y',strtotime($finalIt_DataD2['startDate'])); ?></div></td>
						<?php
						//serial wise loop
						$serviceDetails = '';
						$qIQueryD=''; 
						$qIQueryD=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) ) and startDate="'.$finalIt_DataD2['startDate'].'" order by srn asc');
					 	while($finalIt_DataD=mysqli_fetch_array($qIQueryD)){
			 
							if($finalIt_DataD['serviceType'] == 'transfer' || $finalIt_DataD['serviceType'] == 'transportation'){  
								$transferQuery='';     
								$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" order by fromDate asc ');  
								while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
									
									$transferFlag = 1;
									$c="";  
									$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTransfer['transferId'].'"'); 
									$transferData=mysqli_fetch_array($c);
									
									$d=GetPageRecord('*','quotationTransferMaster','id="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
									$transferQuoteData=mysqli_fetch_array($d);
									
			 						$c="";
									$c=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
									$TimeData=mysqli_fetch_array($c);	
									if(strtotime($TimeData['arrivalTime'])=='1621036800' && strtotime($TimeData['dropTime'])=='1621036800' || strtotime($TimeData['arrivalTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($TimeData['arrivalTime']));
										$endTime24Set = date('H:i',strtotime($TimeData['dropTime']));
									} 
									 
									$d="";
									$d=GetPageRecord('*','vehicleMaster','id="'.$finalQuoteTransfer['vehicleModelId'].'"'); 
									$vehicleData=mysqli_fetch_array($d);
									
									$e="";
									$e=GetPageRecord('*','vehicleBrand','id="'.$vehicleData['brand'].'"'); 
									$vehicleBrandData=mysqli_fetch_array($e); 


									$serviceDetails .= ucfirst($transferData['transferName'])." | ".$vehicleBrandData['name']." | ".$vehicleData['model']; 
									$serviceDetails .= " + ";

								}
							}   

							// Ferry Voucher start 
							if($finalIt_DataD['serviceType'] == 'ferry'){ 
								$ferryQuery='';   
								$ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteFerry=mysqli_fetch_array($ferryQuery)){
									 
									$ccc="";
									 $ccc=GetPageRecord('*','quotationFerryMaster','  id="'.$finalQuoteFerry['ferryQuotationId'].'"'); 
									$TimeData=mysqli_fetch_array($ccc);	

									$dddd="";
									 $dddd=GetPageRecord('*','ferryClassMaster','  id="'.$TimeData['ferryClass'].'"'); 
									$ferryClassname=mysqli_fetch_array($dddd);	


									$dd="";
									$dd=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerry['ferryId'].'"'); 
									$ferryData=mysqli_fetch_array($dd);

									$serviceDetails .= ucfirst($ferryData['name']).' | '.strip($ferryClassname['name']);
									$serviceDetails .= " + ";

									 
								 }  
							} 

							if($finalIt_DataD['serviceType'] == 'entrance'){ 
								$entranceQuery='';   
								$entranceQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteEntrance=mysqli_fetch_array($entranceQuery)){
									 
									//quotationId = "'.$quotationData['id'].'" and
									$c="";
			 						$c=GetPageRecord('*','quotationEntranceTimelineDetails','  hotelQuoteId="'.$finalQuoteEntrance['entranceQuotationId'].'"'); 
									$TimeData=mysqli_fetch_array($c);	
									if(strtotime($TimeData['startTime'])=='1621036800' && strtotime($TimeData['endTime'])=='1621036800' || strtotime($TimeData['startTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($TimeData['startTime']));
										$endTime24Set = date('H:i',strtotime($TimeData['endTime']));
									} 

									$c="";
									$c=GetPageRecord('*','packageBuilderEntranceMaster','id="'.$finalQuoteEntrance['entranceId'].'"'); 
									$entranceData=mysqli_fetch_array($c);

									$serviceDetails .= ucfirst($entranceData['entranceName']); 
									$serviceDetails .= " + ";
								 }  
							}
						 	
						 	if($finalIt_DataD['serviceType'] == 'activity'){
							
								$activityQuery='';   
								$activityQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteActivity=mysqli_fetch_array($activityQuery)){

									$c="";
									$c=GetPageRecord('*','packageBuilderotherActivityMaster','id="'.$finalQuoteActivity['activityId'].'"');
									$activityData=mysqli_fetch_array($c);
			 						
									//quotationId = "'.$quotationData['id'].'" and
									$c="";
									$c=GetPageRecord('*','quotationActivityTimelineDetails',' hotelQuoteId="'.$finalQuoteActivity['activityQuotationId'].'"');
									$TimeData=mysqli_fetch_array($c);
									if(strtotime($TimeData['startTime'])=='1621036800' && strtotime($TimeData['endTime'])=='1621036800' || strtotime($TimeData['startTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($TimeData['startTime']));
										$endTime24Set = date('H:i',strtotime($TimeData['endTime']));
									} 
									$serviceDetails .= ucfirst($activityData['otherActivityName']);
									$serviceDetails .= " + ";

									$cnt++;
								}   
							}
						 
							if($finalIt_DataD['serviceType'] == 'train'){ 
								$trainFlag=1;
								$trainQuery='';   
								$trainQuery=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteTrains=mysqli_fetch_array($trainQuery)){
								 
									$c=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,'id="'.$finalQuoteTrains['trainId'].'"'); 
									$trainData=mysqli_fetch_array($c);	 
			 						 
									// echo $finalQuoteTrains['trainQuotationId']."sssssss";
									$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
									if(trim($finalQuoteTrains['departureTime'])=='' || trim($finalQuoteTrains['arrivalTime'])==''){
										$departureTime = $arrivalTime ='';
									}else{
										$departureTime = date('H:i',strtotime($finalQuoteTrains['departureTime']));
										$arrivalTime = date('H:i',strtotime($finalQuoteTrains['arrivalTime']));
									}
									if(trim($finalQuoteTrains['departureDate'])!='0000-00-00 00:00:00'){
										$departureDate = date('j M Y',strtotime($finalQuoteTrains['departureDate']));
									} 
									if(trim($finalQuoteTrains['arrivalDate'])!='0000-00-00 00:00:00'){
										$arrivalDate = date('j M Y',strtotime($finalQuoteTrains['arrivalDate']));
									} 
									 
									$arrivalTo = getDestination($finalQuoteTrains['arrivalTo']);
									$departureFrom = getDestination($finalQuoteTrains['departureFrom']);
									$trainName = $trainData['trainName'];
									$trainNumber = $finalQuoteTrains['trainNumber']; 
									$trainClass = $finalQuoteTrains['trainClass'];
									
									if($finalQuoteTrains['journeyType'] == 'overnight'){
										$journeyType = 'Overnight';
									}else{
										$journeyType = 'Day';
									}

									$serviceDetails .= "Train : ".ucfirst($trainName).'/'.$trainNumber.'/'.$trainClass."/".$journeyType;  
									$serviceDetails .= " + ";
											
								} 
							} 
						 	
						 	if($finalIt_DataD['serviceType'] == 'flight'){ 
						 		$flightFlag=1;
								$flightQuery='';   
								$flightQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							 	 
								while($finalQuoteFlights=mysqli_fetch_array($flightQuery)){
								 
									$c=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightId'].'"'); 
									$flightData=mysqli_fetch_array($c);	 
									
									if(strtotime($finalQuoteFlights['arrivalTime'])=='1621036800' && strtotime($finalQuoteFlights['departureTime'])=='1621036800' || strtotime($finalQuoteFlights['arrivalTime']) == ''){
										$startTime24Set = $endTime24Set ='';
									}else{
										$startTime24Set = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
										$endTime24Set = date('H:i',strtotime($finalQuoteFlights['departureTime']));
									}  



									$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
									if(trim($finalQuoteFlights['departureTime'])=='' || trim($finalQuoteFlights['arrivalTime'])==''){
										$departureTime = $arrivalTime ='';
									}else{
										$departureTime = date('H:i',strtotime($finalQuoteFlights['departureTime']));
										$arrivalTime = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
									}
									if(trim($finalQuoteFlights['departureDate'])!='0000-00-00 00:00:00'){
										$departureDate = date('j M Y',strtotime($finalQuoteFlights['departureDate']));
									} 
									if(trim($finalQuoteFlights['arrivalDate'])!='0000-00-00 00:00:00'){
										$arrivalDate = date('j M Y',strtotime($finalQuoteFlights['arrivalDate']));
									} 
									 
									$arrivalTo = getDestination($finalQuoteFlights['arrivalTo']);
									$departureFrom = getDestination($finalQuoteFlights['departureFrom']);
									$flightName = $flightData['flightName'];
									$flightNumber = $finalQuoteFlights['flightNumber']; 
									$flightClass = $finalQuoteFlights['flightClass'];
									 
									$serviceDetails .= "Flight : ".ucfirst($flightName).'/'.$flightNumber.'/'.$flightClass;  
									$serviceDetails .= " + ";
	 
								}  
							}

						 	if($finalIt_DataD['serviceType'] == 'mealplan'){
								$mealPlanQuery='';   
								$mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
								while($finalQuoteMealPlan=mysqli_fetch_array($mealPlanQuery)){		
									$serviceDetails .= "".ucfirst($finalQuoteMealPlan['mealPlanName']);  
									$serviceDetails .= " + ";
								}  
							} 
								
							if($finalIt_DataD['serviceType'] == 'additional'){
								$additionalQuery='';   
								$additionalQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
						 	 
								while($finalQuoteadditionalD=mysqli_fetch_array($additionalQuery)){
								
			 						$groupCost = $finalQuoteadditionalD['groupCost'];
									$c=GetPageRecord('*','extraQuotation','id="'.$finalQuoteadditionalD['additionalId'].'"'); 
									$additionalData=mysqli_fetch_array($c);	  


									$serviceDetails .= "".ucfirst($additionalData['name']);  
									$serviceDetails .= " + ";
								}  
							}  

						 	if($finalIt_DataD['serviceType'] == 'guide'){
								 
								$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_DataD['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc ');  
						 		while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){
							 
									$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
									$guideData=mysqli_fetch_array($c);	 
			 						
			 						$serviceDetails .= "".ucfirst($guideData['name']);   
			 						$serviceDetails .= " + ";
								}
							}

						}
						$cnt++;

						?><td colspan="3"> : <?php echo getDestination($cityId)." - ".rtrim($serviceDetails,' + ');?></td>
						</tr>
						<?php
					} 
					?>  
					<!-- end of the services loop from final tables -->
				</table>
				<!-- Arrival Departure for hotel and transfer-->
				<style type="text/css">
					@media print
					{    
					    .removeEle{
					        display: none !important;
					    } 
						table{
							border: 0px solid #fff;
							border-collapse: collapse; 

						}
						input[type=text], input[type=date]{
							width:94%;
						}
					    input, textarea{
							border: 0px solid;
    						border-color: #fff;
							outline: none;		        
					    }
					}
					table{
						border-collapse: collapse; 
					}
					.main-container input[type=text],.main-container input[type=date]{
						width:94%;
					}
					.main-container input, .main-container textarea{
						border: 1px solid;
						border-color: #ccc;
						padding: 3px;
						font-size: 12px;
						outline: none;		        
					}
					.w100{ width: 99%; }
					.hidediv{
				        display: none !important;
				    }
				</style>
				<br>  
				<!-- Arrival Departure for hotel and transfer-->
 				<table  border="0" cellpadding="2" cellspacing="0" class="removeEle">
 					<tr>
						<td><strong>Arrival/Departure Details</strong></td>
						<td ><lable onclick="willPrintNotPrint2(1,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus2 ?>');"  ><input type="radio" name="willPrint2<?php echo $suppStatusId_cnt;?>" id="willPrint2<?php echo $suppStatusId_cnt;?>" value="1" style="display:inline-block;" <?php if ($ADStatus2==1) { echo "checked";} ?>>&nbsp;Will&nbsp;Print</lable></td>
						<td ><lable onclick="willPrintNotPrint2(0,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus2 ?>');" ><input type="radio" name="willPrint2<?php echo $suppStatusId_cnt;?>" id="willNotPrint2<?php echo $suppStatusId_cnt;?>" value="0" style="display:inline-block;" <?php if ($ADStatus2==0) { echo "checked";} ?>>&nbsp;Will&nbsp;Not&nbsp;Print</lable></td>
					</tr>
				</table>
				
				<table  border="0" borderColor="#ccc" cellpadding="2" cellspacing="0"  class="Arrival_DepartureDiv2<?php echo $suppStatusId_cnt;?> <?php if ($ADStatus2==0) { echo "removeEle hidediv";} ?>" >
					<tr>
						<td align="left" valign="middle" width="15%">
							<strong>Arrival On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_arrival_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("d/m/Y", strtotime($fromDate)); }   ?> 
						</td>
						<td align="left" valign="middle"  >
							<strong>From&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_by_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>
						</td> 
					</tr>
					<tr>
						<td align="left" valign="middle">
							<strong>Departure On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_departure_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("d/m/Y", strtotime($toDate));}   ?>
						</td>
						<td align="left" valign="middle">
							<strong>To&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_by_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>
						</td>
					</tr>
				</table> 
				<!-- Notes and Billing INstructions --> 
				<br>
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr align="left" valign="top">
						<td colspan="3">
							<input type="hidden" name="voucherDate<?php echo $suppStatusId_cnt;?>" id="voucherDate<?php echo $suppStatusId_cnt;?>" value="<?php echo $voucherDate; ?>">
							<input type="hidden" name="voucherNumber<?php echo $suppStatusId_cnt;?>" id="voucherNumber<?php echo $suppStatusId_cnt;?>" value="<?php echo $showVocherNum; ?>">
							<strong>Noted to be printed on voucher</strong>
							<textarea id="voucherNotes2<?php echo $suppStatusId_cnt;?>"   class="w100" ><?php if(!empty($voucherNotes2)){ echo strip($voucherNotes2); }else{ 
									echo ''; 
								} ?></textarea> 
								<br>
						</td>
					</tr>
					<tr align="left" valign="top" class="removeEle">
						<td colspan="3"><lable onclick="billInstYes2('<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>')" ><input type="checkbox" value="0"  id="billInstYes2<?php echo $suppStatusId_cnt;?>" style="display: inline-block;" <?php if($billInstYes2==1){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;Billing&nbsp;Instruction</lable>
						</td>
					</tr>
					<tr align="left" valign="top" class="<?php if($billInstYes2==1){ ?> removeEle hidediv <?php } ?> billInstYesDiv2<?php echo $suppStatusId_cnt;?>">
						<td colspan="3">
							<strong>Billing&nbsp;Instructions&nbsp;</strong><br>
							<textarea id="billingInstructions2<?php echo $suppStatusId_cnt;?>"  class="w100"><?php if(!empty($billingInstructions2) or $billInstYes2==0){ echo strip($billingInstructions2); }else{ echo 'Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.'; } ?></textarea>
						</td>
					</tr>
				</table>  
			</td>
			</tr>
		</table>
		
		</div>  
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td colspan="3" align="right">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="right"></td> 
					<td align="right" width="50%" >
						<input type="button" value="Save Changes" style=" background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="saveChanges('<?php echo $suppStatusId_cnt; ?>')"  />  
						<input type="hidden" id="quotationId<?php echo $suppStatusId_cnt;?>" value="<?php echo $quotationId; ?>" />
						<input type="hidden" id="supplierStatusId<?php echo $suppStatusId_cnt;?>" value="<?php echo $supplierStatusId; ?>" /> 
 						<input type="hidden" id="voucherDetailId<?php echo $suppStatusId_cnt;?>" value="<?php echo strip($voucherId); ?>" /> 
					</td>
				</tr>
				<tr><td colspan="3" align="right">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="left"></td>
					<td width="50%" align="right">
						<?php 
						$voucherString=trim($supplierStatusId).'_0_other_'.trim($module).'_'.trim($quotationId).'_1'; 
						?>
						<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&voucherString=<?php echo $voucherString; ?>" target="_blank" style="    border-color: #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>&nbsp;&nbsp; 
						<input type="button"value="Print"  style="    border-color: #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF;border-radius: 2px;" onclick="printDiv('mailSectionArea<?php echo $suppStatusId_cnt; ?>')" class="a" /> 
					
					</td> 
				</tr>
			</table>
		<br>
		<?php 
	} ?>

	<!--Hotel Voucher-->
	<?php
	// for hotel only  
	$dateSets = getHotelDateSets($quotationId,$supplierStatusData['supplierId']);
	$dateSetArray = explode('~',$dateSets);
	$cnt1 = 1;
	if(strlen($dateSets) > 0){ 
	foreach($dateSetArray as $dateSet){

	$suppStatusId_cnt = strip($supplierStatusData['id']."_".$cnt1);
	$supplierStatusId = $supplierStatusData['id'];

	$dateSetData = explode('^',$dateSet);
	$hotelId = $dateSetData[0];
	$fromDate = $dateSetData[1];
	$toDate = $dateSetData[2];
	$FID = $dateSetData[3];
	 
	$c="";
	$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
	$hotelData=mysqli_fetch_array($c); 
	 
	$g="";
	$g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
	$finalHotelData=mysqli_fetch_array($g);
	if($finalHotelData['manualStatus']==3){

		$rooms = '';
		if($quotationData['sglRoom'] > 0){ $rooms .= $quotationData['sglRoom']." SGL ,"; }
		if($quotationData['dblRoom'] > 0){ $rooms .= $quotationData['dblRoom']." DBL ,"; }
		if($quotationData['tplRoom'] > 0){ $rooms .= $quotationData['tplRoom']." TPL ,"; }
		if($quotationData['twinRoom'] > 0){ $rooms .= $quotationData['twinRoom']." TWIN ,"; }
		if($quotationData['extraNoofBed'] > 0){ $rooms .= $quotationData['extraNoofBed']." EBed(A) ,"; }
		if($quotationData['childwithNoofBed'] > 0){ $rooms .= $quotationData['childwithNoofBed']." CWBed ,"; }
		if($quotationData['childwithoutNoofBed'] > 0){ $rooms.= $quotationData['childwithoutNoofBed']." CNBed ,"; }
		
		$noOfRooms = $quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']+$quotationData['twinRoom'];
		
		$g="";
		$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalHotelData['roomType'].'"'); 
		$roomTypeData=mysqli_fetch_array($g);
		$rType=$roomTypeData['name'];
		
		$g="";
		$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalHotelData['mealPlanId'].'"'); 
		$mealData=mysqli_fetch_array($g);
		//.'-'.$mealData['subname'] 
		$mealplan = $mealData['name'];
		 
		$CheckIn = date('d/m/Y',strtotime($fromDate));
		$CheckOut = date('d/m/Y',strtotime($toDate));
		$date1 = new DateTime($fromDate);
		$date2 = new DateTime($toDate);
		$interval = $date1->diff($date2);
		$nights = $interval->days;   
		
		$confNO  = $finalHotelData['confirmationNo'];
		
		// add or update voucher details
		$voucherQuery="";
		$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusData['id'].'" and serviceType="hotel" and serviceId="'.$FID.'" and quotationId="'.$quotationId.'"'); 
		if(mysqli_num_rows($voucherQuery)<1){
			$namevalue ='quotationId="'.$quotationId.'",supplierStatusId="'.$supplierStatusData['id'].'",serviceType="hotel",serviceId="'.$FID.'"';
			$voucherId = addlistinggetlastid('voucherDetailsMaster',$namevalue);
			// get data
			$voucherQuery2=GetPageRecord('*','voucherDetailsMaster','id="'.$voucherId.'" '); 
			$voucherDetailData = mysqli_fetch_array($voucherQuery2);
		} else{
			$voucherDetailData = mysqli_fetch_array($voucherQuery);
			$voucherId  = $voucherDetailData['id'];	
			$voucherDate2  = date('Y-m-d',strtotime($voucherDetailData['voucherDate']));
		} 
		if($module=='ClientVoucher'){
			$ADStatus = $voucherDetailData['cli_ADStatus'];
		 	$voucherNotes = $voucherDetailData['cli_voucherNotes'];
		 	$billInstYes = $voucherDetailData['cli_billInstYes'];
		 	$billingInstructions = $voucherDetailData['cli_billingInstructions'];

			$ADStatus2 = $voucherDetailData['cli_ADStatus2'];
		 	$voucherNotes2 = $voucherDetailData['cli_voucherNotes2'];
		 	$billInstYes2 = $voucherDetailData['cli_billInstYes2'];
		 	$billingInstructions2 = $voucherDetailData['cli_billingInstructions2'];
		}else{
			$ADStatus = $voucherDetailData['sup_ADStatus'];
		 	$billInstYes = $voucherDetailData['sup_billInstYes']; 
		 	$voucherNotes = $voucherDetailData['sup_voucherNotes'];
		 	$billingInstructions = $voucherDetailData['sup_billingInstructions'];

		 	$ADStatus2 = $voucherDetailData['sup_ADStatus'];
		 	$billInstYes2 = $voucherDetailData['sup_billInstYes'];		 	
		 	$voucherNotes2 = $voucherDetailData['sup_voucherNotes'];
		 	$billingInstructions2 = $voucherDetailData['sup_billingInstructions'];
		}
		
		$showVocherNum = generateVoucherNumber($voucherId,$module,strtotime($fromDate));	
		?>
		<div class="sub-container" style="border:1px dashed #ddd;padding:10px;font-size: 12px;" id="mailSectionArea<?php echo $suppStatusId_cnt;?>">
			<br><br><br><br><br><br><br><br><br><br><br>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td> 
				<!--address block-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td width="75%" valign="top">
							<table>
								<tr>
									<td align="left" style="font-size: 16px;">
										<strong>To:&nbsp;<?php echo ucfirst($agentName); ?></strong>
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Address&nbsp;:&nbsp;</strong><?php echo strip($supplierAddData['address']); ?>
									</td>
								</tr>
								<tr>
									<td align="left" >
									<?php if($contactPerson!=''){ ?>
										<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo strip($contactPerson); ?>&nbsp;&nbsp;&nbsp;&nbsp;
									<?php } ?>
										<strong>Phone&nbsp;:&nbsp;</strong><?php  echo $suppagentPone; ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>Email&nbsp;:&nbsp;</strong><?php  echo $suppagentEmail; ?>
									</td>
								</tr>

								<tr>
									<td align="left" ><strong>In favour of&nbsp;:&nbsp;</strong><span ><?php 
									$otherpxQuery=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$quotationId.'" and supplierStatusId="'.$supplierStatusId.'"');
									$ttlOthPx = mysqli_num_rows($otherpxQuery);	
									if($ttlOthPx>0){ 
										$cnt=1;	
										while($otherpaxdata=mysqli_fetch_array($otherpxQuery)){
											echo ucfirst($otherpaxdata['otherGuestName']); 
											if($ttlOthPx>$cnt && ($ttlOthPx-1)!=$cnt){ echo ",&nbsp;&nbsp;";}
											if(($ttlOthPx-1)==$cnt){ echo " and&nbsp;";}
											$cnt++;
										}
										?></span>
									<?php }else{ ?>
									<span ><?php echo strip($resultpage['leadPaxName']);  ?></span>
									<?php } ?>
									</td>
								</tr>
							</table>
						</td>
						<td width="25%" valign="top">
							<table>
								<tr>
									<td  align="left">
										<strong>Tour&nbsp;ID&nbsp;:&nbsp;</strong><?php echo $tourId; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;No&nbsp;:&nbsp;</strong><?php echo $showVocherNum; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;Date&nbsp;:&nbsp;</strong><?php 
										if($voucherDate!='1970-01-01 00:00:00' && $voucherDate!='0000-00-00 00:00:00' && $voucherDate!=''){
											echo date('d/m/Y', strtotime($voucherDate)); 
										}else{ 
											echo date('d/m/Y',strtotime($fromDate)); 
										} ?> 
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $pax; ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<br>
				<!-- Services Date -->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr> 
						<td width="100%"><strong>Please provide the services as per the following.</strong></td> 
					</tr>
				</table> 
				<!-- Service date wise list -->
				<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="2"> 
				 	<tr> 
						<td  width="25%"><b><?php echo strip($hotelData['hotelName']);  ?></b></td>  
						<td colspan="2"><b>CheckIn&nbsp;:&nbsp;</b><?php echo $CheckIn;?>&nbsp;<b>|&nbsp;Check&nbsp;Out&nbsp;:&nbsp;</b><?php echo $CheckOut; ?></td>
						<td width="10%" ><b>Night(s)&nbsp;:&nbsp;</b><?php echo $nights; ?></td>   
						<td width="15%" ><b>Confirmation&nbsp;No&nbsp;:&nbsp;</b><?php echo $confNO; ?></td>   
					</tr>
					<?php  
					$g2="";
					$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and  supplierId="'.$supplierStatusData['supplierId'].'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" group by roomType,mealPlanId  order by fromDate asc'); 
					if(mysqli_num_rows($g2)>0){ 
						while($quotMealData=mysqli_fetch_array($g2)){ 
							
							$g="";
							$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotMealData['roomType'].'"'); 
							$roomTypeData=mysqli_fetch_array($g);
							$rType=$roomTypeData['name'];
								
							$g="";
							$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotMealData['mealPlanId'].'"'); 
							$mealData=mysqli_fetch_array($g);
							//.'-'.$mealData['subname']						
							$mealplan = $mealData['name'];

							$rs12='';
							$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$quotMealData['hotelQuotationId'].'" and quotationId="'.$quotMealData['quotationId'].'" '); 
							while ($addsData=mysqli_fetch_array($rs12)) {
								$additns  .= $addsData['name'].', ';
							}
							?>
							<tr>
								<td align="left"><strong>Date&nbsp;:&nbsp;</strong><?php echo date('d/m/Y',strtotime($quotMealData['fromDate']))."&nbsp;-&nbsp;".date('d/m/Y',strtotime($quotMealData['toDate']) + 86400); ?></td>  
								<td align="left" colspan="2"><strong>Room&nbsp;Type&nbsp;:&nbsp;</strong><?php echo $rType.'/'.$rooms;?></td> 
								<td align="left"><strong>Meal&nbsp;Plan&nbsp;:&nbsp;</strong><?php echo $mealplan; if($quotMealData['lunch']>0 && $quotMealData['complimentaryLunch']==1){ echo ", Lunch"; } if($quotMealData['dinner']>0 && $quotMealData['complimentaryDinner']==1){echo ", Dinner"; } if($quotMealData['breakfast']>0 && $quotMealData['complimentaryBreakfast']==1){echo ", Breakfast"; } ?></td>
								<td align="left"><strong>Additionals&nbsp;:&nbsp;</strong><?php echo rtrim($additns,', '); ?></td> 
							</tr>
							<?php
						}
					}
					?>
					<!-- end of the services loop from final tables -->
				</table>
				<br> 
				<style type="text/css">
					@media print
					{    
					    .removeEle{
					        display: none !important;
					    } 
						table{
							border-collapse: collapse; 
						}
						input[type=text], input[type=date]{
							width:94%;
						}
					    input, textarea{
							border: 0px solid;
    						border-color: #fff;
							outline: none;		        
					    }
					}
					table{
						border-collapse: collapse; 
					}
					.main-container input[type=text],.main-container input[type=date]{
						width:94%;
					}
					.main-container input, .main-container textarea{
						border: 1px solid;
						border-color: #ccc;
						padding: 3px;
						font-size: 12px;
						outline: none;		        
					}
					.w100{ width: 99%; }
					.hidediv{
				        display: none !important;
				    }

				</style>
				<!-- Arrival Departure for hotel and transfer-->
 				<table  border="0" cellpadding="2" cellspacing="0" class="removeEle">
 					<tr>
						<td><strong>Arrival/Departure Details</strong></td>
						<td ><lable onclick="willPrintNotPrint1(1,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus ?>');"  ><input type="radio" name="willPrint1<?php echo $suppStatusId_cnt;?>" id="willPrint1<?php echo $suppStatusId_cnt;?>" value="1" style="display:inline-block;" <?php if ($ADStatus==1) { echo "checked";} ?>>&nbsp;Will&nbsp;Print</lable></td>
						<td ><lable onclick="willPrintNotPrint1(0,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus ?>');" ><input type="radio" name="willPrint1<?php echo $suppStatusId_cnt;?>" id="willNotPrint1<?php echo $suppStatusId_cnt;?>" value="0" style="display:inline-block;" <?php if ($ADStatus==0) { echo "checked";} ?>>&nbsp;Will&nbsp;Not&nbsp;Print</lable></td>
					</tr>
				</table>
				
				<table  border="0" borderColor="#ccc" cellpadding="2" cellspacing="0"  class="Arrival_DepartureDiv1<?php echo $suppStatusId_cnt;?> <?php if ($ADStatus==0) { echo "removeEle hidediv";} ?>" >
					<tr>
						<td align="left" valign="middle" width="15%">
							<strong>Arrival On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_arrival_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("d/m/Y", strtotime($fromDate)); }   ?> 
						</td>
						<td align="left" valign="middle"  >
							<strong>From&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_by_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>
						</td> 
					</tr>
					<tr>
						<td align="left" valign="middle">
							<strong>Departure On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_departure_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("d/m/Y", strtotime($toDate));}   ?>
						</td>
						<td align="left" valign="middle">
							<strong>To&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_by_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>
						</td>
					</tr>
				</table> 
				<!-- Notes and Billing INstructions --> 
				<br>
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr align="left" valign="top">
						<td colspan="3">
							<input type="hidden" name="voucherDate<?php echo $suppStatusId_cnt;?>" id="voucherDate<?php echo $suppStatusId_cnt;?>" value="<?php echo $voucherDate; ?>">
							<input type="hidden" name="voucherNumber<?php echo $suppStatusId_cnt;?>" id="voucherNumber<?php echo $suppStatusId_cnt;?>" value="<?php echo $showVocherNum; ?>">
							<strong>Noted to be printed on voucher</strong>
							<textarea id="voucherNotes1<?php echo $suppStatusId_cnt;?>" class="w100" ><?php if(!empty($voucherNotes)){ echo strip($voucherNotes); }else{ 
									echo ''; 
								} ?></textarea> 
								<br>
						</td>
					</tr>
					<tr align="left" valign="top" class="removeEle">
						<td colspan="3"><lable onclick="billInstYes('<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>')" ><input type="checkbox" value="0"  id="billInstYes1<?php echo $suppStatusId_cnt;?>" style="display: inline-block;" <?php if($billInstYes==1){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;Billing&nbsp;Instruction</lable>
						</td>
					</tr> 
					<tr align="left" valign="top" class="<?php if($billInstYes==1){ ?> removeEle hidediv <?php } ?> billInstYesDiv1<?php echo $suppStatusId_cnt;?>">
						<td colspan="3">
							<strong>Billing&nbsp;Instructions&nbsp;</strong><br>
							<textarea id="billingInstructions1<?php echo $suppStatusId_cnt;?>"  class="w100"><?php if(!empty($billingInstructions) or $billInstYes==0){ echo strip($billingInstructions); }else{ echo 'Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.'; } ?></textarea>
						</td>
					</tr>
				</table>  
				</td>
				</tr>
			</table>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td>
				<!--address block-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr>
						<td width="75%" valign="top">
							<table>
								<tr>
									<td align="left" style="font-size: 16px;">
										<strong>To:&nbsp;<?php echo ucfirst($agentName); ?></strong>
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Address&nbsp;:&nbsp;</strong><?php echo strip($supplierAddData['address']); ?>
									</td>
								</tr>
								<tr>
									<td align="left" >
									<?php if($contactPerson!=''){ ?>
										<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo strip($contactPerson); ?>&nbsp;&nbsp;&nbsp;&nbsp;
									<?php } ?>
										<strong>Phone&nbsp;:&nbsp;</strong><?php  echo $suppagentPone; ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>Email&nbsp;:&nbsp;</strong><?php  echo $suppagentEmail; ?>
									</td>
								</tr>

								<tr>
									<td align="left" ><strong>In favour of&nbsp;:&nbsp;</strong><span ><?php 
									$otherpxQuery=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$quotationId.'" and supplierStatusId="'.$supplierStatusId.'"');
									$ttlOthPx = mysqli_num_rows($otherpxQuery);	
									if($ttlOthPx>0){ 
										$cnt=1;	
										while($otherpaxdata=mysqli_fetch_array($otherpxQuery)){
											echo ucfirst($otherpaxdata['otherGuestName']); 
											if($ttlOthPx>$cnt && ($ttlOthPx-1)!=$cnt){ echo ",&nbsp;&nbsp;";}
											if(($ttlOthPx-1)==$cnt){ echo " and&nbsp;";}
											$cnt++;
										}
										?></span>
									<?php }else{ ?>
									<span ><?php echo strip($resultpage['leadPaxName']);  ?></span>
									<?php } ?>
									</td>
								</tr>
							</table>
						</td>
						<td width="25%" valign="top">
							<table>
								<tr>
									<td  align="left">
										<strong>Tour&nbsp;ID&nbsp;:&nbsp;</strong><?php echo $tourId; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;No&nbsp;:&nbsp;</strong><?php echo $showVocherNum; ?>
									</td>
								</tr>
								<tr>
									<td  align="left">
										<strong>Voucher&nbsp;Date&nbsp;:&nbsp;</strong><?php 
										if($voucherDate!='1970-01-01 00:00:00' && $voucherDate!='0000-00-00 00:00:00' && $voucherDate!=''){
											echo $voucherDate = date('d/m/Y', strtotime($voucherDate)); 
										}else{ 
											echo $voucherDate = date('d/m/Y',strtotime($fromDate)); 
										} ?> 
									</td>
								</tr>
								<tr>
									<td align="left">
										<strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $pax; ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<br>
				<!-- Services Date -->
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<tr> 
						<td width="100%"><strong>Please provide the services as per the following.</strong></td> 
					</tr>
				</table> 
				<!-- Service date wise list -->
				<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="2"> 
				 	<tr> 
						<td  width="25%"><b><?php echo strip($hotelData['hotelName']);  ?></b></td>  
						<td colspan="2"><b>CheckIn&nbsp;:&nbsp;</b><?php echo $CheckIn;?>&nbsp;<b>|&nbsp;Check&nbsp;Out&nbsp;:&nbsp;</b><?php echo $CheckOut; ?></td>
						<td width="10%" ><b>Night(s)&nbsp;:&nbsp;</b><?php echo $nights; ?></td>   
						<td width="15%" ><b>Confirmation&nbsp;No&nbsp;:&nbsp;</b><?php echo $confNO; ?></td>   
					</tr>
					<?php  
					$g2="";
					$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and  hotelId="'.$hotelId.'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" group by roomType,mealPlanId  order by fromDate asc'); 
					if(mysqli_num_rows($g2)>0){ 
						while($quotMealData=mysqli_fetch_array($g2)){ 
							
							$g="";
							$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotMealData['roomType'].'"'); 
							$roomTypeData=mysqli_fetch_array($g);
							$rType=$roomTypeData['name'];
								
							$g="";
							$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotMealData['mealPlanId'].'"'); 
							$mealData=mysqli_fetch_array($g);
							//.'-'.$mealData['subname']						
							$mealplan = $mealData['name'];

							$rs12='';
							$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$quotMealData['hotelQuotationId'].'" and quotationId="'.$quotMealData['quotationId'].'" '); 
							while ($addsData=mysqli_fetch_array($rs12)) {
								$additns  .= $addsData['name'].', ';
							}
							?>
							<tr>
								<td align="left"><strong>Date&nbsp;:&nbsp;</strong><?php echo date('d/m/Y',strtotime($quotMealData['fromDate']))."&nbsp;-&nbsp;".date('d/m/Y',strtotime($quotMealData['toDate']) + 86400); ?></td>  
								<td align="left" colspan="2"><strong>Room&nbsp;Type&nbsp;:&nbsp;</strong><?php echo $rType.'/'.$rooms;?></td> 
								<td align="left"><strong>Meal&nbsp;Plan&nbsp;:&nbsp;</strong><?php echo $mealplan; if($quotMealData['lunch']>0 && $quotMealData['complimentaryLunch']==1){ echo ", Lunch"; } if($quotMealData['dinner']>0 && $quotMealData['complimentaryDinner']==1){echo ", Dinner"; } if($quotMealData['breakfast']>0 && $quotMealData['complimentaryBreakfast']==1){echo ", Breakfast"; } ?></td>
								<td align="left"><strong>Additionals&nbsp;:&nbsp;</strong><?php echo rtrim($additns,', '); ?></td> 
							</tr>
							<?php
						}
					}
					?>
					<!-- end of the services loop from final tables -->
				</table>
				<br> 
				<style type="text/css">
					@media print
					{    
					    .removeEle{
					        display: none !important;
					    } 
						table{
							border-collapse: collapse; 
						}
						input[type=text], input[type=date]{
							width:94%;
						}
					    input, textarea{
							border: 0px solid;
    						border-color: #fff;
							outline: none;		        
					    }
					}
					table{
						border-collapse: collapse; 
					}
					.main-container input[type=text],.main-container input[type=date]{
						width:94%;
					}
					.main-container input, .main-container textarea{
						border: 1px solid;
						border-color: #ccc;
						padding: 3px;
						font-size: 12px;
						outline: none;		        
					}
					.w100{ width: 99%; }
					.hidediv{
				        display: none !important;
				    }

				</style> 
				<!-- Arrival Departure for hotel and transfer-->
 				<table  border="0" cellpadding="2" cellspacing="0" class="removeEle">
 					<tr>
						<td><strong>Arrival/Departure Details</strong></td>
						<td ><lable onclick="willPrintNotPrint2(1,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus2 ?>');"  ><input type="radio" name="willPrint2<?php echo $suppStatusId_cnt;?>" id="willPrint2<?php echo $suppStatusId_cnt;?>" value="1" style="display:inline-block;" <?php if ($ADStatus2==1) { echo "checked";} ?>>&nbsp;Will&nbsp;Print</lable></td>
						<td ><lable onclick="willPrintNotPrint2(0,'<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>','<?php echo $ADStatus2 ?>');" ><input type="radio" name="willPrint2<?php echo $suppStatusId_cnt;?>" id="willNotPrint2<?php echo $suppStatusId_cnt;?>" value="0" style="display:inline-block;" <?php if ($ADStatus2==0) { echo "checked";} ?>>&nbsp;Will&nbsp;Not&nbsp;Print</lable></td>
					</tr>
				</table>
				
				<table  border="0" borderColor="#ccc" cellpadding="2" cellspacing="0"  class="Arrival_DepartureDiv2<?php echo $suppStatusId_cnt;?> <?php if ($ADStatus2==0) { echo "removeEle hidediv";} ?>" >
					<tr>
						<td align="left" valign="middle" width="15%">
							<strong>Arrival On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_arrival_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("d/m/Y", strtotime($fromDate)); }   ?> 
						</td>
						<td align="left" valign="middle"  >
							<strong>From&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php echo strip($voucherDetailData['h_by_from']); ?>
						</td>
						<td align="left" valign="middle"  >
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle"  >
							<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>
						</td> 
					</tr>
					<tr>
						<td align="left" valign="middle">
							<strong>Departure On&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_departure_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("d/m/Y", strtotime($toDate));}   ?>
						</td>
						<td align="left" valign="middle">
							<strong>To&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>By&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php echo strip($voucherDetailData['h_by_to']); ?>
						</td>
						<td align="left" valign="middle">
							<strong>At&nbsp;:&nbsp;</strong>
						</td>
						<td align="left" valign="middle">
							<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>
						</td>
					</tr> 
				</table> 
				<!-- Notes and Billing INstructions --> 
				<br>
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr align="left" valign="top">
						<td colspan="3">
							<input type="hidden" name="voucherDate<?php echo $suppStatusId_cnt;?>" id="voucherDate<?php echo $suppStatusId_cnt;?>" value="<?php echo $voucherDate; ?>">
							<input type="hidden" name="voucherNumber<?php echo $suppStatusId_cnt;?>" id="voucherNumber<?php echo $suppStatusId_cnt;?>" value="<?php echo $showVocherNum; ?>">

							<strong>Noted to be printed on voucher</strong>
							<textarea id="voucherNotes2<?php echo $suppStatusId_cnt;?>"   class="w100" ><?php if(!empty($voucherNotes2)){ echo strip($voucherNotes2); }else{ 
									echo ''; 
								} ?></textarea> 
								<br>
						</td>
					</tr>
					<tr align="left" valign="top" class="removeEle">
						<td colspan="3"><lable onclick="billInstYes2('<?php echo $suppStatusId_cnt;?>','<?php echo $voucherId; ?>')" ><input type="checkbox" value="0"  id="billInstYes2<?php echo $suppStatusId_cnt;?>" style="display: inline-block;" <?php if($billInstYes2==1){ ?> checked<?php } ?> >&nbsp;Clear&nbsp;Billing&nbsp;Instruction</lable>
						</td>
					</tr>
					<tr align="left" valign="top" class="<?php if($billInstYes2==1){ ?> removeEle hidediv <?php } ?> billInstYesDiv2<?php echo $suppStatusId_cnt;?>">
						<td colspan="3">
							<strong>Billing&nbsp;Instructions&nbsp;</strong><br>
							<textarea id="billingInstructions2<?php echo $suppStatusId_cnt;?>"  class="w100"><?php if(!empty($billingInstructions2) or $billInstYes2==0){ echo strip($billingInstructions2); }else{ echo 'Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.'; } ?></textarea>
						</td>
					</tr>
				</table>    
				</td>
				</tr>
			</table>
		</div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td colspan="3" align="right">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="right"></td> 
					<td align="right" width="50%" >
						<input type="button" value="Save Changes" style=" background-color:#009e67; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="saveChanges('<?php echo $suppStatusId_cnt; ?>')"  />  
						<input type="hidden" id="quotationId<?php echo $suppStatusId_cnt;?>" value="<?php echo $quotationId; ?>" />
						<input type="hidden" id="supplierStatusId<?php echo $suppStatusId_cnt;?>" value="<?php echo $supplierStatusId; ?>" /> 
 						<input type="hidden" id="voucherDetailId<?php echo $suppStatusId_cnt;?>" value="<?php echo strip($voucherId); ?>" /> 
					</td>
				</tr>
				<tr><td colspan="3" align="right">&nbsp;</td></tr>
				<tr>
					<td colspan="2" align="left"></td>
					<td width="50%" align="right">
						<?php 
						$voucherString=trim($supplierStatusId).'_'.$FID.'_hotel_'.trim($module).'_'.trim($quotationId).'_1'; 
						?>
						<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($queryId); ?>&voucherString=<?php echo $voucherString; ?>" target="_blank" style="    border-color: #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF!important;border-radius: 2px;">Send</a>&nbsp;&nbsp; 
						<input type="button"value="Print"  style="    border-color: #ccc;padding: 3px 20px;font-size:12px;background-color:#000;color:#FFFFFF;border-radius: 2px;" onclick="printDiv('mailSectionArea<?php echo $suppStatusId_cnt; ?>')" class="a" /> 
					
					</td> 
				</tr>
		</table>
		<br>
		<?php
		$cnt1++;		 
	}
	}
	}
	?>  
	<!-- end of the all blocks -->
	<?php
	
} //endofloop
}
?>   
<script type="text/javascript">
function willPrintNotPrint1(isPrint,eleId,Vid,ADStatus){
	if(isPrint == 1){
		$('#willNotPrint1'+eleId+'').removeAttr('checked');
		$('#willPrint1'+eleId+'').attr('checked','checked');
		$('.Arrival_DepartureDiv1'+eleId+'').removeClass('removeEle hidediv');
		$('#actionBox').load('final_frmaction.php?action=visibleArrivalDepartureTime&module=<?php echo $module; ?>&voucherId='+Vid+'&ADStatus=1&section=1');	
	}else{
		$('#willPrint1'+eleId+'').removeAttr('checked');
		$('#willNotPrint1'+eleId+'').attr('checked','checked');
		$('.Arrival_DepartureDiv1'+eleId+'').addClass('removeEle hidediv');
		$('#actionBox').load('final_frmaction.php?action=visibleArrivalDepartureTime&module=<?php echo $module; ?>&voucherId='+Vid+'&ADStatus=0&section=1');
	}
}

function willPrintNotPrint2(isPrint,eleId,Vid,ADStatus){
	if(isPrint == 1){
		$('#willNotPrint2'+eleId+'').removeAttr('checked');
		$('#willPrint2'+eleId+'').attr('checked','checked');
		$('.Arrival_DepartureDiv2'+eleId+'').removeClass('removeEle hidediv');
		$('#actionBox').load('final_frmaction.php?action=visibleArrivalDepartureTime&module=<?php echo $module; ?>&voucherId='+Vid+'&ADStatus=1&section=2');	
	}else{
		$('#willPrint2'+eleId+'').removeAttr('checked');
		$('#willNotPrint2'+eleId+'').attr('checked','checked');
		$('.Arrival_DepartureDiv2'+eleId+'').addClass('removeEle hidediv');
		$('#actionBox').load('final_frmaction.php?action=visibleArrivalDepartureTime&module=<?php echo $module; ?>&voucherId='+Vid+'&ADStatus=0&section=2');
	}
}
 

function billInstYes(eleId,Vid){

	var voucherNotes = document.getElementById('voucherNotes1' + eleId).value;
	var billingInstructions = document.getElementById('billingInstructions1' + eleId).value;

	if ($('#billInstYes1'+eleId).is(':checked')){  
		$('#billInstYes1'+eleId).removeAttr('checked');
		$('.billInstYesDiv1'+eleId+'').removeClass('removeEle hidediv');

		$('#actionBox').load('final_frmaction.php?action=visiblebillInstYes&module=<?php echo $module; ?>&voucherId='+Vid+'&voucherNotes=' + encodeURI(voucherNotes) + '&billingInstructions=' + encodeURI(billingInstructions) + '&billInstYes=0&section=1');	
	}else{
		$('#billInstYes1'+eleId).attr('checked','checked');
		$('.billInstYesDiv1'+eleId+'').addClass('removeEle hidediv');
		$('#actionBox').load('final_frmaction.php?action=visiblebillInstYes&module=<?php echo $module; ?>&voucherId='+Vid+'&voucherNotes=' + encodeURI(voucherNotes) + '&billingInstructions=' + encodeURI(billingInstructions) + '&billInstYes=1&section=1');
	}
}


function billInstYes2(eleId,Vid){
	
	var voucherNotes = document.getElementById('voucherNotes2' + eleId).value;
	var billingInstructions = document.getElementById('billingInstructions2' + eleId).value;

	if ($('#billInstYes2'+eleId).is(':checked')){  
		$('#billInstYes2'+eleId).removeAttr('checked');
		$('.billInstYesDiv2'+eleId+'').removeClass('removeEle hidediv');
		$('#actionBox').load('final_frmaction.php?action=visiblebillInstYes&module=<?php echo $module; ?>&voucherId='+Vid+'&voucherNotes=' + encodeURI(voucherNotes) + '&billingInstructions=' + encodeURI(billingInstructions) + '&billInstYes=0&section=2');	
	}else{
		$('#billInstYes2'+eleId).attr('checked','checked');
		$('.billInstYesDiv2'+eleId+'').addClass('removeEle hidediv');

		$('#actionBox').load('final_frmaction.php?action=visiblebillInstYes&module=<?php echo $module; ?>&voucherId='+Vid+'&voucherNotes=' + encodeURI(voucherNotes) + '&billingInstructions=' + encodeURI(billingInstructions) + '&billInstYes=1&section=2');
	}
}

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    // Create a new window
    var printWindow = window.open('', '_blank');
    // Add styles with white background and 20px margin to the printed content
    var style = '<style media="print">body { background-color: white; margin: 30px; } input, textarea {font-family: "Roboto", sans-serif;}table{border-collapse: collapse; }.main-container input[type=text],.main-container input[type=date]{width:88%;}.main-container input[type=text],.main-container input[type=date], .main-container textarea{border: 1px solid;border-color: #ccc;padding: 6px;font-size: 13px;outline: none;}.w100{ width: 97% !important; }.hidediv{display: none !important;}.saveBtn{display: inline-block;font-size: 14px!important;cursor: pointer;padding: 5px 7px;border: 1px solid #c5c0c0;border-radius: 1px;}.blueBtn{color: #ffffff!important;background-color: #007bff!important;}.whiteBtn{color: #212529!important;background-color: #f8f9fa!important;}.grnBtn{color: #ffffff!important;background-color: #28a745!important;}.blackBtn{color: #fff!important;background-color: #343a40!important;border-color: #343a40!important;}.bill_cls{height: 50px !important;}</style>';

    // Set the content of the new window with the styles and the original content
    printWindow.document.write(style + printContents);
    // Close the document stream to ensure proper rendering
    printWindow.document.close();
    // Print the content
    printWindow.print();
    // Close the new window after printing
    printWindow.close();
    // Reload the parent location
    parent.location.reload();
    // return false;
}

function saveChanges(boxId) { 
	var supplierStatusId = document.getElementById('supplierStatusId' + boxId).value; 

	var voucherNotes = document.getElementById('voucherNotes1' + boxId).value;
	var billingInstructions = document.getElementById('billingInstructions1' + boxId).value;

	var voucherNotes2 = document.getElementById('voucherNotes2' + boxId).value;
	var billingInstructions2 = document.getElementById('billingInstructions2' + boxId).value;

	var id = document.getElementById('voucherDetailId' + boxId).value;

	$('#actionBox').load('final_frmaction.php?action=saveVoucherArrivalDeparturePrePrint&module=<?php echo $module; ?>&supplierStatusId=' + encodeURI(supplierStatusId) + '&id=' + encodeURI(id) + '&voucherNotes=' + encodeURI(voucherNotes) + '&billingInstructions=' + encodeURI(billingInstructions) + '&voucherNotes2=' + encodeURI(voucherNotes2) + '&billingInstructions2=' + encodeURI(billingInstructions2) + '&quotationId=<?php echo $quotationId; ?>'); 
}

</script>
<div style="display:none" id="actionBox"></div>
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.timepicker2').timepicker();
});   
</script>
<!--only use for check in time-->								
</div> 
</div>
