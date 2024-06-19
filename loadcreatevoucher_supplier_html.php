<?php
include "inc.php"; 
if(strlen($_REQUEST['string']) > 5){
	$postArray = explode("_", trim($_REQUEST['string']));
	//933_0_other_ClientVoucher_1457_1
	$supplierStatusId = $postArray['0'];
	$serviceId = $postArray['1'];
	$serviceType = $postArray['2'];
	$voucherModule = $postArray['3'];
	$quotationId = $postArray['4'];
	$aspdf = $postArray['5'];
}else{
	$supplierStatusId = $_REQUEST['supplierStatusId'];
	$serviceId = $_REQUEST['serviceId'];
	$serviceType = $_REQUEST['serviceType'];
	$voucherModule = $_REQUEST['module'];
	$quotationId =$_REQUEST['quotationId'];
	$aspdf = 0;
}
//quotation data 
$rs=''; 
$rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"  '); 
$quotationData=mysqli_fetch_array($rs);
$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
 $pax = ($quotationData['adult']+$quotationData['child']);
$costType = $quotationData['costType'];
$discountType= $quotationData['discountType'];
$discountTax = $quotationData['discount'];

//slab Date
$slabSql="";
$slabSql=GetPageRecord('*','totalPaxSlab','1 and quotationId="'.$quotationId.'"  and status=1'); 
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
  
$n=1;
?> 
 
<div class="main-container" >
<?php  
//supplier wise voucher loop 
// and status=3
$fianlSuppQuery="";
$fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' quotationId="'.$quotationData['id'].'" and id="'.$supplierStatusId.'" and deletestatus=0 '); 
if(mysqli_num_rows($fianlSuppQuery)>0){
	while($supplierStatusData=mysqli_fetch_array($fianlSuppQuery)){

		$b="";
		$b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$supplierStatusData['supplierId'].'"'); 
		$suppData=mysqli_fetch_array($b);  

		if($voucherModule=='SupplierVoucher'){
			$b="";
			$b=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$suppData['id'].'" and addressType="supplier"'); 
			$supplierAddData=mysqli_fetch_array($b);  
		 
			$b="";
			$b=GetPageRecord('*','suppliercontactPersonMaster',' corporateId="'.$supplierStatusData['supplierId'].'" and contactPerson!="" and deletestatus=0 '); 
			$resListing=mysqli_fetch_array($b);
		
		}elseif ($voucherModule=='ClientVoucher'){
			$dq=GetPageRecord('*',_QUERY_MASTER_,' id="'.$resultpage['id'].'" order by id desc');  
			$queryData=mysqli_fetch_array($dq);
		
			if($queryData['clientType']=='1'){
		
				$ad=GetPageRecord('*',_CORPORATE_MASTER_,' id="'.$queryData['companyId'].'" order by id desc');  
				$suppData=mysqli_fetch_array($ad);
		
		
				$rsss=GetPageRecord('*','contactPersonMaster',' corporateId="'.$suppData['id'].'" and contactPerson!="" and deletestatus=0 order by id asc'); 
		
				$resListing=mysqli_fetch_array($rsss);
		
				$rssupad=GetPageRecord('*','addressMaster',' addressParent="'.$suppData['id'].'" and addressType="corporate" order by id asc'); 
				$supplierAddData=mysqli_fetch_array($rssupad);
		
			}
			if($queryData['clientType']=='2'){
		
				$ad=GetPageRecord('*',_CONTACT_MASTER_,' id="'.$queryData['companyId'].'" order by id desc');  
				$suppData=mysqli_fetch_array($ad);
		
				$suppData['name'] = ($suppData['firstName'].' '.$suppData['lastName']);
		
				$supplierAddData['address'] = $suppData['address1'];
		
				$resListing['contactPerson'] = $suppData['name'];
		
		
				$rsss=GetPageRecord('*',_PHONE_MASTER_,' masterId="'.$suppData['id'].'"  and sectionType="contacts"  order by id asc'); 
		
				$resListingp=mysqli_fetch_array($rsss);
		
				$resListing['phone'] = $resListingp['phoneNo'];
		
				$rssupad=GetPageRecord('*',_EMAIL_MASTER_,' masterId="'.$suppData['id'].'" and sectionType="contacts"  order by id asc'); 
				$emailData=mysqli_fetch_array($rssupad);
		
				$resListing['email'] = $emailData['email'];
		
				$supplierAddData['gstn'] = '';
		
		
			} 
		
		}else{ 
		}
	   	
		if($serviceType=='other' && $serviceId == 0){
		$qIQuery2='';  
	 	//serviceId in ( select id from finalQuote where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" ) or 
		$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )) group by startDate order by startDate asc');
		if(mysqli_num_rows($qIQuery2) > 0){	
	 	// add or update voucher details
		$voucherQuery="";
		$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusData['id'].'" and serviceType="other" and serviceId=0 and quotationId="'.$quotationId.'"');  
		$voucherDetailData = mysqli_fetch_array($voucherQuery);
		$voucherId  = $voucherDetailData['id'];	
		$queryfromDate2  = date('j M Y',strtotime($voucherDetailData['voucherDate']));
		
		$showVocherNum = generateVoucherNumber($voucherId,$voucherModule,strtotime($queryfromDate));	
	 	$suppStatusId_cnt = $supplierStatusData['id'];
		?>
		<!--All services vouchers lists except hotel-->
		<div class="sub-container"  style="border:1px dashed #ddd;<?php if($aspdf ==1){ ?>padding:10px 20px;<?php } ?>" >
		<table width="100%" border="0" cellpadding="0" cellspacing="15">
		<tr>
		<td> 
			<!--logo block-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr>
					<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px margin: 0 auto;" /></td></tr>
			</table>
			<br /><br />
			<!--address block-->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td  align="left" style="font-size: 16px;"><span style="font-weight: bold;">
									To: &nbsp;</span>
									<strong><?php echo strip($suppData['name'] ); ?></strong>
								</td>
							</tr>
							<tr>
								<td align="left"><span style="font-weight: bold;">
									Address&nbsp;:&nbsp;</span>
									<?php echo strip($supplierAddData['address']); ?>
								</td>
							</tr>
							<tr>
								<td align="left"><span style="font-weight: bold;">
									Contact&nbsp;Person&nbsp;:&nbsp;</span>
									<?php echo strip($resListing['contactPerson']); ?> </td>
							</tr>
							<tr>
								<td align="left"><span style="font-weight: bold;">
									Phone&nbsp;:&nbsp;</span>
									<?php echo decode($resListing['phone']); ?>
								</td>
							</tr>
							<tr>
								<td align="left"><span style="font-weight: bold;">
									Email&nbsp;:&nbsp;</span>
									<?php echo decode(strip($resListing['email'])); ?> </td>
							</tr>
						</table>
					</td>
					<td>
						<table>
		
							<tr>
								<td  align="left"><span style="font-weight: bold;">
									Tour No&nbsp;:&nbsp;</span>
									<?php echo $tourId; ?>
								</td>
							</tr>
							<tr>
								<td align="left"><span style="font-weight: bold;">
									Tour Date&nbsp;:&nbsp;</span>
									<?php echo date('d/m/Y', strtotime($resultpage['fromDate']) ); ?>
								</td>
							</tr>
							<?php
							if ($voucherModule == 'SupplierVoucher') { ?>
							<tr>
								<td align="left"><span style="font-weight: bold;">
									Lead Pax Name&nbsp;:&nbsp;</span>
									<?php echo $resultpage['leadPaxName']; ?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td align="left"><span style="font-weight: bold;">
									No&nbsp;Of&nbsp;Pax&nbsp;:&nbsp;</span>
									<?php echo $pax; ?>
								</td>
							</tr> 
							<tr>
								<td  align="left"><span style="font-weight: bold;">
									Booking No: &nbsp;</span>
									<?php echo $bookingId; ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<br /> <br />
			<!-- manually voucher no and date -->
			<table width="100%" border="0" cellspacing="0" borderColor="#ccc" cellpadding="0" style="font-size:12px;">
				<tr>
					<th align="left" width="50%">
						Voucher&nbsp;No.
					</th>
					<th align="left" width="35%">
						Voucher&nbsp;Date
					</th>
					<th align="left" width="15%">
						Reference&nbsp;No.
					</th> 
				</tr>
				<tr> 
					<td width="50%"> <?php echo $showVocherNum; ?> 
					</td>
					<td width="35%"><?php if($queryfromDate2!='1970-01-01' && $queryfromDate2!='0000-00-00' && $queryfromDate2!=''){ echo date('j M Y', strtotime($queryfromDate2)); }else{ echo date('j M Y',strtotime($queryfromDate)); } ?>
					</td>
					<td>
						<?php echo $resultpage['referanceNumber']; ?>
					</td> 
				</tr >
			</table>
			<br /><br />

			<!--In favour of:--> 
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr> 
					<th align="left" width="34%">In favour of:</th>
					<td align="left" width="35%"><?php echo $leadPaxName; ?></td>
					<td ><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; } ?></td>
				</tr>
			</table>
			
			<!--In favour of:--> 
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
			   <tr>
				  <th align="left" width="50%">Lead&nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</th>
				  <td width="35%"><span  style="width:140px;  padding:3px; font-size:12px;"><?php echo strip($resultpage['leadPaxName']);  ?></span></td>
				  <td width="15%">&nbsp;</td>
			   </tr>
			</table> 
			<br />

			<div id="addotherGuest<?php echo $suppStatusId_cnt;?>">
				<table width="55%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-top:5px;">
				<?php 
				$otherpaxes = 1;
				$rs12=""; 
				$rs12=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$quotationId.'" and supplierStatusId="'.$suppStatusId_cnt.'"');  
				while($editresult2=mysqli_fetch_array($rs12)){
				?>
				<tr>
				<th align="left" style="min-width: 80px;"><?php echo 'Pax'.' '.$otherpaxes; ?></th>
				<td style="min-width: 565px;"><?php echo $editresult2['otherGuestName']; ?></td>
				<!-- <td style="min-width: 157px;" align="center"><i class="fa fa-trash" aria-hidden="true" style="font-size: 13px; color: red; cursor:pointer;" onclick="delother('<?php echo $editresult2['id']; ?>','<?php echo $editresult2['supplierStatusId']; ?>');"></i></td> -->
				</tr>
				<?php $otherpaxes++; } ?>
				</table>
			</div>
			
			<!-- Services Date -->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
				<tr> 
					<th align="left" style="min-width: 78px;">Services:</th>
					<th align="left" style="min-width: 501px;">&nbsp;Please provide the services as per the following.</th> 
				</tr>
			</table> <br />
			<br />

			<!-- Service date wise list -->
			<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#ccc"   style="font-size:13px;"> 
				
				<!-- services loop without hotel-->
				<?php  
				$cnt=0;
				while($finalIt_Data2=mysqli_fetch_array($qIQuery2)){ 
					if($cnt == 0){
						$startDate=$finalIt_Data2['startDate'];
					}
					$endDate = $finalIt_Data2['startDate'];
					if($cnt != 0){
					?>
					<tr> 
						<td colspan="4">&nbsp;</td>
					</tr>
					<?php } ?>
					<tr> 
						<td colspan="4"><strong style="font-size: 14px;"><em><?php echo date('d M Y',strtotime($finalIt_Data2['startDate']));?></em></strong></td>
					</tr>
					<?php
					//serial wise loop
					$qIQuery='';
					//serviceId in ( select id from finalQuote where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or 
					$qIQuery=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) ) and startDate="'.$finalIt_Data2['startDate'].'" order by srn asc');
					while($finalIt_Data=mysqli_fetch_array($qIQuery)){
		 
						if($finalIt_Data['serviceType'] == 'transfer' || $finalIt_Data['serviceType'] == 'transportation'){ 
		
							$transferQuery='';    
							$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" order by fromDate asc ');  
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
								?> 
								
								<tr> 
									<td  colspan="4">
										<?php 
										$c="";
										$c=GetPageRecord('*','quotationTransferTimelineDetails','  transferQuoteId="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
										if(mysqli_num_rows($c)>0){
											$TimeData=mysqli_fetch_array($c);	
											$pickupTime24Set = $startTime24Set = $endTime24Set ='';
											if(trim($TimeData['dropTime'])=='' || trim($TimeData['arrivalTime'])==''){
												$startTime24Set = $endTime24Set ='';
											}else{
												$startTime24Set = date('H:i',strtotime($TimeData['arrivalTime']));
												$endTime24Set = date('H:i',strtotime($TimeData['dropTime']));
											}
											if(trim($TimeData['pickupTime'])!=''){
												$pickupTime24Set = date('H:i',strtotime($TimeData['pickupTime']));
											} 
											
											$arrivalFrom = $TimeData['arrivalFrom'];
											$pickupAddress = $TimeData['pickupAddress'];
											$dropAddress = $TimeData['dropAddress'];
											$airportName = $TimeData['airportName'];
											$byMode = $TimeData['mode'];
											if($TimeData['mode'] == 'flight'){
												$modeName = $TimeData['flightName'];
												$modeNumber = $TimeData['flightNumber']; 
											}else{
												$modeName = $TimeData['trainName'];
												$modeNumber = $TimeData['trainNumber']; 
											} 
										}
										?>
										<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="5" style="font-size:13px;"> 
										<tr>
											<th align="left" bgcolor="#F3F3F3" colspan="4" >
												Transport&nbsp;Name
											</th> 
											<th align="left" bgcolor="#F3F3F3">
												Confirmation&nbsp;No.
											</th>
										</tr>
										<tr> 
											<td colspan="4" valign="middle"><?php echo strip($transferData['transferName'])." | ".$vehicleBrandData['name']." | ".$vehicleData['model']; ?></td> 
											<td ><strong><em><?php echo strip($finalQuoteTransfer['confirmationNo']); ?></em></strong></td>
										</tr>
										<tr>
											<th align="left" bgcolor="#F3F3F3">
												Arrival&nbsp;From									
											</th>
											<th align="left" bgcolor="#F3F3F3">
												By&nbsp;Mode									
											</th>
											<th align="left" bgcolor="#F3F3F3">
												<?php if($byMode =='flight'){ echo "Flight"; } else{ echo "Train"; } ?>&nbsp;Name</th>
											<th align="left" bgcolor="#F3F3F3">
												<?php if($byMode =='flight'){ echo "Flight"; } else{ echo "Train"; } ?>&nbsp;Number	</th>
											<th align="left" bgcolor="#F3F3F3" >
												Arv/Dpt&nbsp;Time									
											</th>
										</tr>
										<tr>
											<td><?php echo strip($arrivalFrom); ?></td> 
											<td><?php echo ucfirst($byMode); ?></td> 
											<td><?php echo strip($modeName); ?></td> 
											<td><?php echo $modeNumber; ?></td> 
											<td><?php echo $startTime24Set; ?></td> 
										</tr>
										<tr>
											<th align="left" bgcolor="#F3F3F3" >
												Pickup&nbsp;Time								
											</th>
											<th align="left" bgcolor="#F3F3F3">
												Drop Time
											</th>
											<th align="left" bgcolor="#F3F3F3">
												Airport&nbsp;Name
											</th>
											<th align="left" bgcolor="#F3F3F3">
												Pickup&nbsp;Address
											</th>
											<th align="left" bgcolor="#F3F3F3">
												Drop&nbsp;Address
											</th>
										</tr>
										<tr>
											<td><?php echo $pickupTime24Set; ?></td> 
											<td><?php echo $endTime24Set; ?></td> 
											<td><?php echo strip($airportName); ?></td> 
											<td><?php echo strip($pickupAddress); ?></td> 
											<td><?php echo strip($dropAddress); ?></td> 
										</tr>
										</table>
										
									</td> 
								</tr>
								<?php
							}
						}    
		

						// Ferry mail body voucher

						if($finalIt_Data['serviceType'] == 'ferry'){ 
							$ferryQuery='';   
							$ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							while($finalQuoteFerry=mysqli_fetch_array($ferryQuery)){
								 
								//quotationId = "'.$quotationData['id'].'" and
								$ccc="";
 								$ccc=GetPageRecord('*','quotationFerryMaster','  id="'.$finalQuoteFerry['ferryQuotationId'].'"'); 
								$TimeData=mysqli_fetch_array($ccc);	 

								$dddd="";
 								$dddd=GetPageRecord('*','ferryClassMaster','  id="'.$TimeData['ferryClass'].'"'); 
								$ferryClassname=mysqli_fetch_array($dddd);
								
								$dd="";
								$dd=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerry['ferryId'].'"'); 
								$ferryData=mysqli_fetch_array($dd);
		
								?>  
								<tr>
									<th align="left" bgcolor="#F3F3F3" >
										Ferry&nbsp;Name
									</th>
									<th align="left" bgcolor="#F3F3F3" width="35%">
										Seat&nbsp;Type
									</th>
									<th align="left" bgcolor="#F3F3F3">
										Arrival&nbsp;Time
									</th>
									<th align="left" bgcolor="#F3F3F3">
										Departure&nbsp;Time
									</th>
									<th align="left" bgcolor="#F3F3F3">
										Confirmation&nbsp;No.
									</th>
								</tr>
								<tr> 
								<td><?php echo strip($ferryData['name']); ?></td> 
								<td><?php echo strip($ferryClassname['name']); ?></td> 
								<td><?php echo $TimeData['pickupTime']; ?></td> 
								<td><?php echo $TimeData['dropTime']; ?></td> 
								<td style="font-size:16px"><strong><em> <?php echo strip($finalQuoteFerry['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							 }  
						}

						// Ferry mail body voucher


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
		
								?>  
								<tr>
									<th align="left" bgcolor="#F3F3F3" >
										Entrance&nbsp;Name
									</th>
									<th align="left" bgcolor="#F3F3F3">
										Start&nbsp;Time
									</th>
									<th align="left" bgcolor="#F3F3F3">
										<strong>End&nbsp;Time</strong>
									</th>
									<th align="left" bgcolor="#F3F3F3">
										Confirmation&nbsp;No.
									</th>
								</tr>
								<tr> 
									<td><?php echo strip($entranceData['entranceName']); ?></td> 
									<td><?php echo $startTime24Set; ?></td> 
									<td><?php echo $endTime24Set; ?></td> 
									<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteEntrance['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							 }  
						}
						
						if($finalIt_Data['serviceType'] == 'activity'){
						
							$activityQuery='';   
							$activityQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
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
								?>
								<tr>
									<th align="left" bgcolor="#F3F3F3" >
										Activity&nbsp;Name
									</th>
									<th align="left" bgcolor="#F3F3F3">
										Start&nbsp;Time
									</th>
									<th align="left" bgcolor="#F3F3F3">
										End&nbsp;Time
									</th>
									<th align="left" bgcolor="#F3F3F3">
										Confirmation&nbsp;No.
									</th>
								</tr>
								<tr> 
									<td><?php echo strip($activityData['otherActivityName']); ?></td> 
									<td><?php echo $startTime24Set; ?></td> 
									<td><?php echo $endTime24Set; ?></td> 
									<td style="font-size:20px;"><strong><em><?php echo strip($finalQuoteActivity['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
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
								
								$c=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,'id="'.$finalQuoteTrains['trainQuotationId'].'"'); 
								$trainQuoteData=mysqli_fetch_array($c);	
								  
								?>   
								<tr> 
									<td  colspan="4">
										<?php

										$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
										if(trim($trainQuoteData['departureTime'])=='' || trim($trainQuoteData['arrivalTime'])==''){
											$departureTime = $arrivalTime ='';
										}else{
											$departureTime = date('H:i',strtotime($trainQuoteData['departureTime']));
											$arrivalTime = date('H:i',strtotime($trainQuoteData['arrivalTime']));
										}
										if(trim($trainQuoteData['departureDate'])!='0000-00-00'){
											$departureDate = date('j M Y',strtotime($trainQuoteData['departureDate']));
										} 
										if(trim($trainQuoteData['arrivalDate'])!='0000-00-00'){
											$arrivalDate = date('j M Y',strtotime($trainQuoteData['arrivalDate']));
										} 
										
										$arrivalTo = getDestination($trainQuoteData['arrivalTo']);
										$departureFrom = getDestination($trainQuoteData['departureFrom']);
										$trainName = $trainData['trainName'];
										$trainNumber = $trainQuoteData['trainNumber']; 
										$trainClass = $trainQuoteData['trainClass'];
										
										if($trainQuoteData['journeyType'] == 'overnight'){
											$journeyType = 'Overnight';
										}else{
											$journeyType = 'Day';
										}
										?>
										<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="5" style="font-size:13px;"> 
										<tr>
											<th align="left" bgcolor="#F3F3F3"colspan="3">
												Train&nbsp;Name
											</th> 
											<th align="left" bgcolor="#F3F3F3">
												Confirmation&nbsp;No.
											</th>
										</tr>
										<tr> 
											<td colspan="3"><?php echo strip($trainName); echo "&nbsp;/Journey&nbsp;Type - ".$journeyType; ?></td>  
											<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteTrains['confirmationNo']); ?></em></strong></td>
										</tr>
										<tr>  
											<th align="left" width="25%" >
												Train&nbsp;Number									
											</th>
											<th align="left" width="25%">
												Departure&nbsp;From									
											</th> 
											<th align="left" width="25%" >
												Arrival&nbsp;To									
											</th> 
											<th align="left" width="25%">
												Train&nbsp;Class									
											</th>
										</tr>
										<tr> 
											<td><?php echo $trainNumber; ?></td> 
											<td><?php echo strip($departureFrom); ?></td> 
											<td><?php echo strip($arrivalTo); ?></td> 
											<td><?php echo $trainClass; ?></td> 
										</tr>
										<tr>
											<th align="left" >
												Departure&nbsp;Date
											</th>
											<th align="left" >
												Departure&nbsp;Time
											</th>
											<th align="left">
												Arrival&nbsp;Date
											</th>
											<th align="left" >
												Arrival&nbsp;Time
											</th>
										</tr>
										<tr>
											<td><?php echo $departureDate; ?></td> 
											<td><?php echo $departureTime; ?></td> 
											<td><?php echo $arrivalDate; ?></td> 
											<td><?php echo $arrivalTime; ?></td> 
										</tr>
										</table>
									</td> 
								</tr>
								<?php 
							} 
						} 
						
						if($finalIt_Data['serviceType'] == 'flight'){ 
							$flightFlag=1;
							$flightQuery='';   
							$flightQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							 
							while($finalQuoteFlights=mysqli_fetch_array($flightQuery)){
							 
								$c=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightId'].'"'); 
								$flightData=mysqli_fetch_array($c);	 
								
								$c="";
								$c=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,'id="'.$finalQuoteFlights['flightQuotationId'].'"'); 
								$flightQuoteData=mysqli_fetch_array($c);
								?> 
								<tr> 
									<td  colspan="4">
										<?php  
										$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
										if(trim($flightQuoteData['departureTime'])=='' || trim($flightQuoteData['arrivalTime'])==''){
											$departureTime = $arrivalTime ='';
										}else{
											$departureTime = date('H:i',strtotime($flightQuoteData['departureTime']));
											$arrivalTime = date('H:i',strtotime($flightQuoteData['arrivalTime']));
										}
										if(trim($flightQuoteData['departureDate'])!='0000-00-00'){
											$departureDate = date('j M Y',strtotime($flightQuoteData['departureDate']));
										} 
										if(trim($flightQuoteData['arrivalDate'])!='0000-00-00'){
											$arrivalDate = date('j M Y',strtotime($flightQuoteData['arrivalDate']));
										} 
										 
										$arrivalTo = getDestination($flightQuoteData['arrivalTo']);
										$departureFrom = getDestination($flightQuoteData['departureFrom']);
										$flightName = $flightData['flightName'];
										$flightNumber = $flightQuoteData['flightNumber']; 
										$flightClass = $flightQuoteData['flightClass'];
										 
										?>
										<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="5" style="font-size:13px;"> 
										<tr>
											<th align="left" bgcolor="#F3F3F3"  colspan="3">
												Flight&nbsp;Name
											</th> 
											<th align="left" bgcolor="#F3F3F3">
												Confirmation&nbsp;No.
											</th>
										</tr>
										<tr> 
											<td colspan="3"><?php echo strip($flightData['flightName']); ?></td>  
											<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteFlights['confirmationNo']); ?></em></strong></td>
										</tr>
										<tr>
											
											<th align="left">
												Flight&nbsp;Number								
											</th>
											<th align="left" >
												Departure&nbsp;From									
											</th> 
											<th align="left" >
												Arrival&nbsp;To								
											</th> 
											<th align="left" >
												Flight&nbsp;Class								
											</th>
										</tr>
										<tr> 
											<td><?php echo $flightNumber; ?></td> 
											<td><?php echo strip($departureFrom); ?></td> 
											<td><?php echo strip($arrivalTo); ?></td> 
											<td><?php echo $flightClass; ?></td> 
										</tr>
										<tr>
											<th align="left" >
												Departure&nbsp;Date
											</th>
											<th align="left" >
												Departure&nbsp;Time
											</th>
											<th align="left" >
												Arrival&nbsp;Date
											</th>
											<th align="left" >
												Arrival&nbsp;Time
											</th>
										</tr>
										<tr> 
											<td><?php echo $departureDate; ?></td> 
											<td><?php echo $departureTime; ?></td> 
											<td><?php echo $arrivalDate; ?></td> 
											<td><?php echo $arrivalTime; ?></td> 
										</tr>
										</table>
									</td>
								</tr>
								<?php  
							}  
						} 
		
						if($finalIt_Data['serviceType'] == 'mealplan'){
							$mealPlanQuery='';   
							$mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
							while($finalQuoteMealPlan=mysqli_fetch_array($mealPlanQuery)){		
								 
								?> 
								<tr>
									<th align="left" bgcolor="#F3F3F3" colspan="3">
										Service&nbsp;Name
									</th> 
									<th align="left" bgcolor="#F3F3F3">
										Confirmation&nbsp;No.
									</th>
								</tr>
								<tr> 
									<td colspan="3" ><?php echo strip($finalQuoteMealPlan['mealPlanName']); ?></td>  
									<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteMealPlan['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							}  
						} 
							
						if($finalIt_Data['serviceType'] == 'additional'){
							$additionalQuery='';   
							$additionalQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
						 
							while($finalQuoteadditionalD=mysqli_fetch_array($additionalQuery)){
							
								$groupCost = $finalQuoteadditionalD['groupCost'];
								$c=GetPageRecord('*','extraQuotation','id="'.$finalQuoteadditionalD['additionalId'].'"'); 
								$additionalData=mysqli_fetch_array($c);	  
								?>
								<tr>
									<th align="left" bgcolor="#F3F3F3"  colspan="3" >
										Service&nbsp;Name
									</th> 
									<th align="left" bgcolor="#F3F3F3">
										Confirmation&nbsp;No.
									</th>
								</tr>
								<tr> 
									<td colspan="3" ><?php echo strip($additionalData['name']); ?></td>  
									<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteadditionalD['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php
							}  
						} 
					 
						if($finalIt_Data['serviceType'] == 'enroute'){
							$enrouteQuery='';   
							$enrouteQuery=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 		
							while($finalQuoteEnroute=mysqli_fetch_array($enrouteQuery)){
							 
								$c=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,'id="'.$finalQuoteEnroute['enrouteId'].'"'); 
								$enrouteData=mysqli_fetch_array($c);	
		 
								?> 
								<tr>
									<th align="left" bgcolor="#F3F3F3"colspan="3" >
										Service&nbsp;Name
							</th> 
									<th align="left" bgcolor="#F3F3F3">
										Confirmation&nbsp;No.
							</th>
								</tr>
								<tr> 
									<td colspan="3" ><?php echo strip($enrouteData['enrouteName']); ?></td>  
									<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteEnroute['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							}  
						} 
					 
						if($finalIt_Data['serviceType'] == 'guide'){
					 
		
							$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'"   and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'"   order by fromDate asc ');  
							while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){
						 
								$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
								$guideData=mysqli_fetch_array($c);	 
		 
								?> 
								<tr>
									<th align="left" bgcolor="#F3F3F3" colspan="3" >
										Service&nbsp;Name
							        </th> 
									<th align="left" bgcolor="#F3F3F3">
										<strong>Confirmation&nbsp;No.</strong>
									</th>
								</tr>
								<tr> 
									<td colspan="3" ><?php echo strip($guideData['name']); ?></td>  
									<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteGuides['confirmationNo']); ?></em></strong></td>
								</tr>
								<?php 
							}
						}
					}
					$cnt++;
				} 
			
				?>  
				<!-- end of the services loop from final tables -->
			</table>
			<br />
			<br />

			<!-- Arrival Departure for hotel and transfer-->
			<?php if ($voucherDetailData['ArrivalDepartureStatus']==0) { ?>

			<table width="100%" border="1" borderColor="#ccc" cellpadding="4" cellspacing="0">
				<tr>
					<th align="left" valign="middle" >
						Arrival On
				</th>
					<td align="left" valign="middle"  >
						<span style="width:94%;  padding:3px; font-size:12px;"><?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("j M Y");} ?></span> 
					</td>
					<th align="left" valign="middle"  >
							From
					</th>
					<td align="left" valign="middle"  >
						<span style="width:94%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_from']); ?></span>
					</td>
					<th align="left" valign="middle"  >
						By 
					</th>
					<td align="left" valign="middle"  >
						<span style="width:94%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_by_from']); ?></span> 
					</td>
					<th align="left" valign="middle"  >
						At 
					</th>
					<td align="left" valign="middle"  >
						<span style="width:94%;  padding:3px; font-size:12px;"><?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?></span>
					</td>   
				</tr>
				<tr>
					<th align="left" valign="middle">
						Departure On 
					</th>
					<td align="left" valign="middle">
						<span style="width:94%;  padding:3px; font-size:12px;"><?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("j M Y");}   ?></span>
					</td>
					<th align="left" valign="middle">
						To 
					</th>
					<td align="left" valign="middle">
						<span style="width:94%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_to']); ?></span>
					</td>
					<th align="left" valign="middle">
						By 
					</th>
					<td align="left" valign="middle">
						<span style="width:94%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_by_to']); ?></span>
					</td>
					<th align="left" valign="middle">
						At 
					</th>
					<td align="left" valign="middle">
						<span style="width:94%;  padding:3px; font-size:12px;"><?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?></span>
					</td>
				</tr> 
			</table>   
			<?php } ?>
			<br>
			<!-- Notes and Billing INstructions --> 
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr align="left" valign="top">
					<td colspan="3">
						<div class="griddiv">
							<label><span style="font-weight: bold;"> Notes&nbsp;</span><br>
								<p><?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ 
										echo ''; 
									} ?></p>
							</label>
						</div>
					</td>
				</tr>
				<?php if($voucherDetailData['billInstYes']==1){ ?>
				<tr align="left" valign="top">
					<td colspan="3">
						<div class="griddiv">
							<label>
								<span style="font-weight: bold;">Billing Instructions:&nbsp;&nbsp;</span><br><?php 
								if(!empty($voucherDetailData['billingInstructions']) or $voucherDetailData['billInstYes']==0){ 
									echo strip($voucherDetailData['billingInstructions']); 
								}else{ 
										echo 'Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.'; 
								} ?>
							</label>
						</div>
					</td>
				</tr>
				<?php } ?>
			</table>  
		</td>
		</tr>
		</table>
		</div> 
		<?php 
		} 
		}
		?>
		<!--Hotel Voucher-->
		<?php
		// for hotel only  
		$dateSets = getHotelDateSets($quotationId,$supplierStatusData['supplierId']);
		$dateSetArray = explode('~',$dateSets);
		$cnt1 = 1; 
		if(strlen($dateSets) > 0){ 
			foreach($dateSetArray as $dateSet){
				
				$suppStatusId_cnt = strip($supplierStatusData['id']."_".$cnt1);
				
				$dateSetData = explode('^',$dateSet);
				$hotelId = $dateSetData[0];
				$fromDate = $dateSetData[1];
				$toDate = $dateSetData[2];
				$FID = $dateSetData[3];
				
				$g="";
				$g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
				$finalHotelData=mysqli_fetch_array($g);
				
				if($serviceType == 'hotel' && $serviceId==$FID && $finalHotelData['manualStatus']==3){ 
					$c="";
					$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
					$hotelData=mysqli_fetch_array($c); 
					 
					
					
					$g="";
					$g=GetPageRecord('*',_QUOTATION_HOTEL_MASTER_,'id="'.$finalHotelData['hotelQuotationId'].'"'); 
					$quotationHotelData=mysqli_fetch_array($g);	
					
					$g="";
					$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotationHotelData['roomType'].'"'); 
					$roomTypeData=mysqli_fetch_array($g);
					$rType=$roomTypeData['name'];

					$rooms = '';
				if($quotationData['sglRoom'] > 0){ $rooms .= $quotationData['sglRoom']." SGL ,"; }
				if($quotationData['dblRoom'] > 0){ $rooms .= $quotationData['dblRoom']." DBL ,"; }
				if($quotationData['tplRoom'] > 0){ $rooms .= $quotationData['tplRoom']." TPL ,"; }
				if($quotationData['twinRoom'] > 0){ $rooms .= $quotationData['twinRoom']." TWIN ,"; }
				if($quotationData['extraNoofBed'] > 0){ $rooms .= $quotationData['extraNoofBed']." EBed(A) ,"; }
				if($quotationData['childwithNoofBed'] > 0){ $rooms .= $quotationData['childwithNoofBed']." CWBed ,"; }
				if($quotationData['childwithoutNoofBed'] > 0){ $rooms.= $quotationData['childwithoutNoofBed']." CNBed ,"; }
                    
                    $noOfRooms = $quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']+$quotationData['twinRoom']+$quotationData['childwithNoofBed'];


					
					$g="";
					$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotationHotelData['mealPlan'].'"'); 
					$mealData=mysqli_fetch_array($g); 
					//.'-'.$mealData['subname']
					$mealplan = $mealData['name'];
					 
					$CheckIn = "CheckIn :".date('d M Y',strtotime($fromDate));
					$CheckOut = " CheckOut :".date('d M Y',strtotime($toDate));
					$date1 = new DateTime($fromDate);
					$date2 = new DateTime($toDate);
					$interval = $date1->diff($date2);
					$nights = $interval->days;   
					
					$confNO  = $finalHotelData['confirmationNo'];
					
					// add or update voucher details
					$voucherQuery="";
					$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusData['id'].'" and serviceType="hotel" and serviceId="'.$FID.'" and quotationId="'.$quotationId.'"'); 
					$voucherDetailData = mysqli_fetch_array($voucherQuery);
					$voucherId  = $voucherDetailData['id'];	
					$voucherDate2  = date('j M Y',strtotime($voucherDetailData['voucherDate']));
					
					$showVocherNum = generateVoucherNumber($voucherId,$voucherModule,strtotime($fromDate));
					?>
					<div class="sub-container" style="border:1px dashed #ddd;<?php if($aspdf ==1){ ?>padding:10px 50px;<?php } ?>" >
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					  <tr>
						<td><!--logo block-->
							<table width="100%" border="0" cellpadding="0" cellspacing="0" >
							  <tr>
								<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px margin: 0 auto;" /></td>
							  </tr>
							</table>
						  	<br>
						  	<br>
						  	<br>
							<!--address block-->
							<style>
							
							</style>
							<table width="100%" border="0" cellpadding="0" cellspacing="0" >
							  <tr>
								<td width="40%"><table>
								<tr>
									  <td  align="left" style="font-size: 16px;"><span style="font-weight: bold;">To: </span>&nbsp; <?php echo strip($suppData['name'] ); ?> </td>
									</tr>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Address&nbsp;:&nbsp;</span> <?php echo strip($supplierAddData['address']); ?> </td>
									</tr>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Contact&nbsp;Person&nbsp;:&nbsp;</span> <?php echo strip($resListing['contactPerson']); ?> </td>
									</tr>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Phone&nbsp;:&nbsp;</span> <?php echo decode($resListing['phone']); ?> </td>
									</tr>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Email&nbsp;:&nbsp;</span> <?php echo decode(strip($resListing['email'])); ?> </td>
									</tr>
								</table></td>
								<td width="30%"><table>
									<tr>
									  <td  align="left"><span style="font-weight: bold;">Tour No&nbsp;:&nbsp;</span> <?php echo $tourId; ?> </td>
									</tr>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Tour Date&nbsp;:&nbsp;</span> <?php echo date('d/m/Y', strtotime($resultpage['fromDate']) ); ?> </td>
									</tr>
									<?php
									if ($voucherModule == 'SupplierVoucher') { ?>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Lead Pax Name&nbsp;:&nbsp;</span> <?php echo $resultpage['leadPaxName']; ?> </td>
									</tr>
									<?php 
									}
									if ($voucherModule == 'ClientVoucher') { ?>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Supplier Name&nbsp;:&nbsp;</span> <?php echo $suppData['name']; ?> </td>
									</tr>
									<?php } ?>
									<tr>
									  <td align="left"><span style="font-weight: bold;">Total&nbsp;Pax:&nbsp;</span> <?php echo $pax; ?> </td>
									</tr>
									<tr>
									  <td  align="left"><span style="font-weight: bold;">Booking No:&nbsp;</span><?php echo $bookingId; ?> </td>
									</tr>
								</table></td>
							  </tr>
							  <tr><td>&nbsp;</td></tr>
							</table>
						  
							<!-- manually voucher no and date -->
							<table width="100%" border="0" cellspacing="0" bordercolor="#ccc" cellpadding="0" style="font-size:12px;">
							  <tr>
								<th width="34%" align="left">Voucher&nbsp;No. </th>
								<th width="33%" align="left">Voucher&nbsp;Date</th>
								<th width="33%" align="left">Reference&nbsp;No.</th>
							  </tr>
							  <tr>
								<td><?php echo $showVocherNum; ?></td>
								<td><?php if($voucherDate2!='1970-01-01 00:00:00' && $voucherDate2!='0000-00-00' && $voucherDate2!=''){ echo date('j M Y', strtotime($voucherDate2)); }else{ echo date('j M Y',strtotime($fromDate)); } ?></td>
								<td align="left"><?php echo $resultpage['referanceNumber']; ?></td>
							  </tr>
							</table>
						  
							<!--In favour of:-->

							<table width="100%" border="0" cellpadding="0" cellspacing="0" >
							  <tr>
								<th width="34%" align="left">In favour of:</th>
								<td width="25%" align="left"><?php echo $leadPaxName; ?></td>
								<td ><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; } ?></td>
							  </tr>
							</table>
						  
							<!--In favour of:-->
							<table width="100%" border="0" cellpadding="0" cellspacing="0" >
							  <tr>
								<th width="34%" align="left">Lead&nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</th>
								<td width="33%"><span style="width:97%; font-size:12px;"><?php echo strip($resultpage['leadPaxName']);?></span></td>
								<td >&nbsp;</td>
							  </tr>
							</table>
						    <br />
							<br /> 
							<div >
							<?php 
							$rs12=""; 
							$rs12=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$quotationId.'" and supplierStatusId="'.$suppStatusId_cnt.'"'); 
							if(mysqli_num_rows($rs12)>0){ 						
							?>
							<table width="98%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-top:5px;">
							<?php	
							$otherpaxes=1;
							while($editresult2=mysqli_fetch_array($rs12)){
							?>
							<tr>
							<th align="left" style="min-width: 80px;"><?php echo 'Pax'.' '.$otherpaxes; ?></th>	
							<td style="min-width: 499px;"><?php echo $editresult2['otherGuestName']; ?></td>
							<!-- <td width="27%" align="center"><i class="fa fa-trash" aria-hidden="true" style="font-size: 13px; color: red; cursor:pointer;" onclick="delother('<?php echo $editresult2['id']; ?>','<?php echo $editresult2['supplierStatusId']; ?>');"></i></td> -->
							</tr>
							<?php $otherpaxes++; } ?>
							</table>
							<?php
							}
							?>
							</div> 
							
							<!-- Services Date -->
							<table width="99%" border="1" cellpadding="3" cellspacing="0" >
							  <tr>
								<th width="36%" align="left" >Services:</th>
								<td width="64%"><strong>Please provide the services as per the following.</strong></td>
							  </tr>
							</table>
							<!-- Service date wise list -->
							<table width="99%" border="1" cellspacing="0" bordercolor="#ccc" cellpadding="4">
							<tr>
								<th bgcolor="#F3F3F3" width="5%" align="center" rowspan="3"><?php echo 1; ?></th>
								<th bgcolor="#F3F3F3" width="30%"><?php echo strip($hotelData['hotelName']); ?></th>
								<th bgcolor="#F3F3F3"><?php echo $CheckIn;?></th>
								<th bgcolor="#F3F3F3"><?php echo $CheckOut; ?></th>
								<th bgcolor="#F3F3F3"><?php echo $nights." Night(s)"; ?></th> 
						 	</tr>
						  	<tr>
								<th ><?php echo "Confirmation Number" ?></th>
								<th colspan="4"><?php echo $confNO; ?></th>
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
									?>
							  <tr>
								<td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size:13px;">
								<thead>
									<tr bgcolor="#cccccc">
									  <th align="center">Date</th>
									  <th align="center" style="min-width:300px;">Room Type/No.Rooms</th>
									  <th align="center">Meal Plan</th>
									</tr>
									</thead>
									<tr>
									  <td  align="center" width="30%"><?php echo date('d M',strtotime($quotMealData['fromDate']))." - ".date('d M Y',strtotime($quotMealData['toDate']) + 86400); ?></td>
									  <td  align="center" width="29%">&nbsp;&nbsp;<?php echo $rType.'/ '.$rooms;?></td>
									  <td align="center" ><?php echo $mealplan; if($quotMealData['lunch']>0 && $quotMealData['complimentaryLunch']==1){ echo ", Lunch"; } if($quotMealData['dinner']>0 && $quotMealData['complimentaryDinner']==1){echo ", Dinner"; } if($quotMealData['breakfast']>0 && $quotMealData['complimentaryBreakfast']==1){echo ", Breakfast"; } ?></td>
									</tr>
								</table></td>
							  </tr>
							  <?php
								}
								$rs12='';
								$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$finalHotelData['hotelQuotationId'].'" and quotationId="'.$finalHotelData['quotationId'].'" '); 
								while ($editresult2=mysqli_fetch_array($rs12)) {
									$rtype  .= $editresult2['name'].', ';
								}
								?>
								<tr> 
									<td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
									<tr>
										<td width="20%"><b>Hotel Additionals: </b></td>  
										<td width="80%"><?php echo rtrim($rtype,', '); ?></td> 
									</tr>
									</table></td>
								</tr> 
								<?php
							}
								?>
							  <!-- end of the services loop from final tables -->
							</table>
						  	<br>
						  	<br>
						  	<?php if ($voucherDetailData['ArrivalDepartureStatus']==0) { ?>
							<!-- Arrival Departure for hotel and transfer-->
							<table width="96.5%" border="1" bordercolor="#ccc" cellpadding="4" cellspacing="0" >
							  <tr>
								<th align="left" valign="middle" width="15%">Arrival On</th>
								<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; font-size:12px;">
								  <?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("j M Y", strtotime($fromDate));}   ?>
								</span> </td> 
								<th align="left" valign="middle"  >From</th>
								<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_from']); ?></span> </td>
								
								<th align="left" valign="middle"  >By</th>
								<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_by_from']); ?></span> </td>
								
								<th align="left" valign="middle"  >At</th>
								<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; font-size:12px;">
								  <?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>
								</span> </td>
							  </tr>
							  <tr>
								<th align="left" valign="middle">Departure On</th>
								<td align="left" valign="middle"><span style="width:97%;  padding:3px; font-size:12px;">
								  <?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("j M Y", strtotime($toDate));}   ?>
								</span> </td> 
								<th align="left" valign="middle">To </th>
								<td align="left" valign="middle"><span style="width:97%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_to']); ?></span> </td>
	 							<th align="left" valign="middle">By </th>
								<td align="left" valign="middle"><span style="width:97%;  padding:3px; font-size:12px;"><?php echo strip($voucherDetailData['h_by_to']); ?></span> </td>
								<th align="left" valign="middle">At </th>
								<td align="left" valign="middle"><span style="width:97%;  padding:3px; font-size:12px;">
								  <?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?>
								</span> </td>
							  </tr>
							  <tr align="left" valign="top">
								<td colspan="11">&nbsp;</td>
							  </tr>
							</table>
							<?php } ?>
							<br>
						  	<!-- Notes and Billing INstructions -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
							  <tr align="left" valign="top">
								<th colspan="3"><div class="griddiv">
									<label><strong>Notes</strong><br>
										<?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ echo ''; } ?>
									</label>
								</div></th>
							  </tr>
							  <?php if($voucherDetailData['billInstYes']==0){ ?> 
							  <tr align="left" valign="top">
								<td colspan="3"><div class="griddiv">
									<label>
										<strong>Billing Instructions</strong><br>
										<?php if(!empty($voucherDetailData['billingInstructions']) or $voucherDetailData['billInstYes']==0){ 
											echo strip($voucherDetailData['billingInstructions']); 
											}else{ 
												echo 'Bill us for the services and please collect all extras directly. ISSUE SUBJECT TO TERMS AND CONDITIONS.'; 
											} ?> 
									</label>
								</div></td>
							  </tr>
							  <?php } ?>
						  	</table>
						</td>
					  </tr>
					</table>
					</div>
					<?php
				}
				$cnt1++;		 
			}
		}
		?>  
		<!-- end of the all blocks -->
		<?php
		
	} //endofloop
} 
?>    
</div> 
