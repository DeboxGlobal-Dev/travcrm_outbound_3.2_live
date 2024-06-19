<?php
include "inc.php"; 
if($_REQUEST['string']!=''){
	$postArray = explode("_", trim($_REQUEST['string']));
	// print_r($postArray);
	$supplierStatusId = $postArray['0'];
	$serviceId = $postArray['1'];
	$serviceType = $postArray['2'];
	$module = $postArray['3'];
	$quotationId = $postArray['4'];
	$aspdf = $postArray['5'];
	
	$fqssQuery = ' and startDate in ( select startDate from finalquotationItinerary where id="'.$supplierStatusId.'") ';
}elseif($_REQUEST['allvoucher']!=''){
	$postArray = explode("_", trim($_REQUEST['allvoucher']));
	$quotationId = $postArray['0'];
	$module = $postArray['1']; //'ClientVoucher';
	$aspdf = $postArray['2']; //1,0;
	$fqssQuery = ' ';
}else{
	$supplierStatusId = $_REQUEST['supplierStatusId'];

	$serviceId = $_REQUEST['serviceId'];
	$serviceType = $_REQUEST['serviceType'];
	$module = $_REQUEST['module'];
	$quotationId =$_REQUEST['quotationId'];
	$aspdf = 0;
	$fqssQuery = ' and startDate in ( select startDate from finalquotationItinerary where id="'.$supplierStatusId.'") ';
}

$rs=''; 
$rs=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'" and status=1 '); 
$quotationData=mysqli_fetch_array($rs);
$quotationId = $quotationData['id']; 
$queryId = $quotationData['queryId']; 
$totalPax = ($quotationData['adult']+$quotationData['child']+$quotationData['infant']);
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
<!-- style="padding: 40px;background-color: #fff;width: 800px;" -->
<div class="main-container" >
<?php  
//supplier wise voucher loop 
// and status=3
$fianlSuppQuery="";
$fianlSuppQuery=GetPageRecord('*','finalQuotSupplierStatus',' id="'.$supplierStatusId.'" '); 
if(mysqli_num_rows($fianlSuppQuery)>0){
while($supplierStatusData=mysqli_fetch_array($fianlSuppQuery)){

	$b="";
	$b=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$supplierStatusData['supplierId'].'"'); 
	$suppData=mysqli_fetch_array($b);  
	if($module=='SupplierVoucher'){
		$b="";
		$b=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$suppData['id'].'" and addressType="supplier"'); 
		$supplierAddData=mysqli_fetch_array($b);  
	 
		$b="";
		$b=GetPageRecord('*','suppliercontactPersonMaster',' corporateId="'.$supplierStatusData['supplierId'].'" and contactPerson!="" and deletestatus=0 '); 
		$resListing=mysqli_fetch_array($b);


		$agentName = $suppData['name'];
		$contactPerson = $resListing['contactPerson'];
		$suppagentPone = decode($resListing['phone']);
		$suppagentEmail = decode($resListing['email']);
	}
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

   
	// other vouchers 
	if($serviceType == 'other' && $serviceId==0 || $_REQUEST['allvoucher']!='' ){ 
		$qIQuery2='';  
		$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) )  group by startDate order by startDate asc');

		if(mysqli_num_rows($qIQuery2) > 0){
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
			$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
			$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);
	   		$isShowSupCont = 0;
			$isShowSupCont = $suppvoucherNotes['supplierStatus'];
		 	if($module=='ClientVoucher'){
				$ADStatus = $voucherDetailData['cli_ADStatus'];
			 	$voucherNotes = $voucherDetailData['cli_voucherNotes'];
			 	$billInstYes = $voucherDetailData['cli_billInstYes'];
			 	$billingInstructions = $voucherDetailData['cli_billingInstructions'];
			}else{
				$ADStatus = $voucherDetailData['sup_ADStatus'];
			 	$voucherNotes = $voucherDetailData['sup_voucherNotes'];
			 	$billInstYes = $voucherDetailData['sup_billInstYes'];
			 	$billingInstructions = $voucherDetailData['sup_billingInstructions'];
			}

			$showVocherNum = generateVoucherNumber($voucherId,$module,strtotime($queryfromDate));	
		 	$suppStatusId_cnt = $supplierStatusData['id'];
		 	$supplierStatusId = $supplierStatusData['id'];

			?>
			<!--All services vouchers lists except hotel-->
			<div class="sub-container"  width="700"  style="width:700px;font-size: 16px;font-family: sans-serif;<?php if($aspdf ==1){ ?>padding:10px 50px;<?php } ?>" ><table width="700" border="2" cellpadding="15" cellspacing="0">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td> 
					<!--logo block removed-->
					<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					  <tr>
						<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px margin: 0 auto;" /></td>
					  </tr>
					</table> 
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
									<?php if($isShowSupCont == 1){ ?>
									<tr>
										<td align="left" >
										<?php if($contactPerson!=''){ ?>
											<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo strip($contactPerson); ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<?php } ?>
											<strong>Phone&nbsp;:&nbsp;</strong><?php  echo $suppagentPone; ?>&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>Email&nbsp;:&nbsp;</strong><?php  echo $suppagentEmail; ?>
										</td>
									</tr>
									<?php } ?>
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
											<strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $totalPax; ?>
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

							<!-- Value Added Services Block Starts -->
				
				<br>
				<?php 
				$VBRC = GetPageRecord('*','finalQuoteVisa','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
				if(mysqli_num_rows($VBRC)>0){
				?>
				<div><strong>VISA Details</strong></div>
				<table width="100%" border="1" cellpadding="0" cellspacing="0">
					<tr>
					<th width="30%">Visa Name</th>
					<th width="30%">Visa Type</th>
					<th>Adult</th>
					<th>Child</th>
					<th>Infant</th>
					</tr>
				
				<?php
			
				while($visaQuoteData = mysqli_fetch_array($VBRC)){

				 $rsV = GetPageRecord('*',_VISA_TYPE_MASTER_,'id="'.$visaQuoteData['visaTypeId'].'"');
				 $visaType = mysqli_fetch_array($rsV);
				?>
				<tr>
					<td><?php echo $visaQuoteData['name'] ?></td>
					<td><?php echo $visaType['name'] ?></td>
					<td><?php echo $visaQuoteData['adultPax'] ?></td>
					<td><?php echo $visaQuoteData['childPax'] ?></td>
					<td><?php echo $visaQuoteData['infantPax'] ?></td>
				</tr>
				<?php

			}
			?>
			</table>
			<?php }

				$PRS = GetPageRecord('*','finalQuotePassport','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
				if(mysqli_num_rows($PRS)>0){
			?>
				<br>
				<div><strong>Passport Details</strong></div>
				<table width="100%" border="1" cellpadding="1" cellspacing="0">
					<tr>
					<th width="30%">Passport Name</th>
					<th width="30%">Passport Type</th>
					<th>Adult</th>
					<th>Child</th>
					<th>Infant</th>
					</tr>
				
				<?php
				
				while($passportQuoteData = mysqli_fetch_array($PRS)){

				 $rsP = GetPageRecord('*',_PASSPORT_TYPE_MASTER_,'id="'.$passportQuoteData['passportTypeId'].'"');
				 $passportType = mysqli_fetch_array($rsP);
				?>
				<tr>
					<td><?php echo $passportQuoteData['name'] ?></td>
					<td><?php echo $passportType['name'] ?></td>
					<td><?php echo $passportQuoteData['adultPax'] ?></td>
					<td><?php echo $passportQuoteData['childPax'] ?></td>
					<td><?php echo $passportQuoteData['infantPax'] ?></td>
				</tr>
				<?php

			}
			?>
			</table>
		<?php }
		$PRS = GetPageRecord('*','finalQuoteInsurance','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
		if(mysqli_num_rows($PRS)>0){
		?>
				<br>
				<div><strong>Insurance Details</strong></div>
				<table width="100%" border="1" cellpadding="0" cellspacing="0">
					<tr>
					<th width="30%">Insurance Name</th>
					<th width="30%">Insurance Type</th>
					<th>Adult</th>
					<th>Child</th>
					<th>Infant</th>
					</tr>
				
				<?php
				
				while($insuranceQuoteData = mysqli_fetch_array($PRS)){

				 $rsI = GetPageRecord('*',_INSURANCE_TYPE_MASTER_,'id="'.$insuranceQuoteData['insuranceTypeId'].'"');
				 $insuranceType = mysqli_fetch_array($rsI);
				?>
				<tr>
					<td><?php echo $insuranceQuoteData['name'] ?></td>
					<td><?php echo $insuranceType['name'] ?></td>
					<td><?php echo $insuranceQuoteData['adultPax'] ?></td>
					<td><?php echo $insuranceQuoteData['childPax'] ?></td>
					<td><?php echo $insuranceQuoteData['infantPax'] ?></td>
				</tr>
				<?php

			}
			?>
			</table>
			<?php } ?>
			<br>
			<!-- Value Added Services Block Ends -->
					  
					<!-- Service date wise list -->
					<table width="100%" border="0" cellspacing="0" borderColor="#ccc" cellpadding="0" style="font-size:13px;"><?php  
				 		$cnt=0; 
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
							// <tr><td colspan="4">&nbsp;</td></tr>
							} ?><tr><td><?php echo date('d M Y',strtotime($finalIt_Data2['startDate'])); ?></td>
							<?php
							//serial wise loop
							$serviceDetails = '';
							$qIQuery=''; 
							$qIQuery=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and totalPax="'.$slabId.'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and supplierId="'.$supplierStatusData['supplierId'].'"  and manualStatus=3 ) ) and startDate="'.$finalIt_Data2['startDate'].'" order by srn asc');


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
									$ferryQuery=GetPageRecord('*','finalQuoteFerry','quotationId="'.$quotationData['id'].'" and id="'.$finalIt_Data['serviceId'].'" and supplierId = "'.$supplierStatusData['supplierId'].'" order by fromDate asc '); 
									while($finalQuoteFerry=mysqli_fetch_array($ferryQuery)){
										 
										$ccc="";
										 $ccc=GetPageRecord('*','quotationFerryMaster','id="'.$finalQuoteFerry['ferryQuotationId'].'"'); 
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


										if($finalQuoteActivity['transferType'] == 1){
											$transferType = 'SIC';
										 }elseif($finalQuoteActivity['transferType'] == 2){
											$transferType = 'PVT';
										 }if($finalQuoteActivity['transferType'] == 3){
											$transferType = 'VIP';
										 }
				 						
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
										$serviceDetails .= $transferType.' | '. ucfirst($activityData['otherActivityName']);
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



										?>

										<!-- started for train reservation request detail -->
								<!-- <tr> -->
									
								<?php 
									$rsst = GetPageRecord('*','trainMultiDetailMaster','quotationId="'.$finalQuoteTrains['quotationId'].'" and parentId="'.$finalQuoteTrains['id'].'"');
									if(mysqli_num_rows($rsst)>0){
										
										?>
								<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="" style="font-size:13px;">
									<tbody>
										<tr>  
											<td width="18%" >
												<strong>Title&nbsp;</strong>									
											</td>
											<td width="18%" >
												<strong>First&nbsp;Name</strong>									
											</td>
											<td width="18%" >
												<strong>Middle&nbsp;Name</strong>									
											</td>
											<td width="18%" >
												<strong>Last&nbsp;Name</strong>									
											</td>
												<td  width="17%">
												<strong>Gender</strong>									
											</td> 
											<td width="13%" >
												<strong>PNR&nbsp;No.</strong>									
											</td> 
											<td  width="30%">
												<strong>Confirmation&nbsp;No.</strong>									
											</td>
										</tr>
										<?php 
										
										while($trainmultData = mysqli_fetch_assoc($rsst)){
										?>
										<tr>  
											<td width="18%" >
											<?php echo strip($trainmultData['title']); ?>								
											</td>
											<td width="18%" >
											<?php echo strip($trainmultData['firstName']); ?>									
											</td>
											<td width="18%" >
											<?php echo ($trainmultData['middleName']); ?>									
											</td>
											<td width="18%" >
											<?php echo strip($trainmultData['lastName']); ?>									
											</td>
												<td  width="17%">
												<?php echo strip($trainmultData['gender']); ?>			
											</td> 
											<td width="13%" >
											<?php echo strip($trainmultData['pnrNo']); ?>								
											</td> 
											<td  width="30%">
											<?php echo strip($trainmultData['confirmationNo']); ?>								
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<?php } ?>
									
									<br>
									<!-- </tr> -->
										<!-- ended for train reservation request detail -->
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
										
										$c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$finalQuoteFlights['flightQuotationId'].'" and quotationId="'.$finalQuoteFlights['quotationId'].'" and dayId="'.$finalQuoteFlights['dayId'].'"');
										$timeData = mysqli_fetch_assoc($c1);
										$via = $timeDate['via'];
										
										if(strtotime($finalQuoteFlights['arrivalTime'])=='1621036800' && strtotime($finalQuoteFlights['departureTime'])=='1621036800' || strtotime($finalQuoteFlights['arrivalTime']) == ''){
											$startTime24Set = $endTime24Set ='';
										}else{
											$startTime24Set = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
											$endTime24Set = date('H:i',strtotime($finalQuoteFlights['departureTime']));
										}  



										$departureTime = $arrivalTime = $departureDate = $arrivalDate='';
										if(trim($timeData['departureTime'])==''){
											$departureTime = $arrivalTime ='';
										}else{
											$departureTime = date('H:i',strtotime($timeData['departureTime']));
											$arrivalTime = date('H:i',strtotime($finalQuoteFlights['arrivalTime']));
										}

										if(trim($timeData['departureDate'])!='0000-00-00 00:00:00'){
											$departureDate = date('j M Y',strtotime($timeData['departureDate']));
										} 
									
										 
										$arrivalTo = getDestination($finalQuoteFlights['arrivalTo']);
										$departureFrom = getDestination($finalQuoteFlights['departureFrom']);
										$flightName = $flightData['flightName'];
										$flightNumber = $finalQuoteFlights['flightNumber']; 
										$flightClass = $finalQuoteFlights['flightClass'];
										
										 
										$serviceDetails .= ' - '.$via.', '."Flight : ".ucfirst($flightName).'/'.$flightNumber.'/'.$flightClass.'/'.$departureDate.'/'.$departureTime;  
										$serviceDetails .= " + ";

										
									?>
									<!-- started for train reservation request detail -->
									
									<?php 
									$rss = GetPageRecord('*','flightMultiDetailMaster','quotationId="'.$finalQuoteFlights['quotationId'].'" and parentId="'.$finalQuoteFlights['id'].'"');
											if(mysqli_num_rows($rss)>0){
										
										?>
									<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="" style="font-size:13px;">
										<tbody>
											<tr>  
												<td width="18%" >
													<strong>Title&nbsp;</strong>									
												</td>
												<td width="18%" >
													<strong>First&nbsp;Name</strong>									
												</td>
												<td width="18%" >
													<strong>Middle&nbsp;Name</strong>									
												</td>
												<td width="18%" >
													<strong>Last&nbsp;Name</strong>									
												</td>
													<td  width="17%">
													<strong>Gender</strong>									
												</td> 
												<td width="13%" >
													<strong>PNR&nbsp;No.</strong>									
												</td> 
												<td  width="30%">
													<strong>Confirmation&nbsp;No.</strong>									
												</td>
											</tr>
											<?php
												while($flightmultData = mysqli_fetch_assoc($rss)){  ?>
											<tr>  
												<td width="18%" >
												<?php echo strip($flightmultData['title']); ?>								
												</td>
												<td width="18%" >
												<?php echo strip($flightmultData['firstName']); ?>									
												</td>
												<td width="18%" >
												<?php echo strip($flightmultData['middleName']); ?>									
												</td>
												<td width="18%" >
												<?php echo strip($flightmultData['lastName']); ?>									
												</td>
													<td  width="17%">
													<?php echo strip($flightmultData['gender']); ?>			
												</td> 
												<td width="13%" >
												<?php echo strip($flightmultData['pnrNo']); ?>								
												</td> 
												<td  width="30%">
												<?php echo strip($flightmultData['confirmationNo']); ?>								
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
									<?php } ?>
									
									<br>
										<!-- ended for train reservation request detail -->
								<?php
		 
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

							?><td colspan="3">  <?php echo getDestination($cityId)." - ".rtrim($serviceDetails,' + ');?></td>
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
					<?php if ($ADStatus==1) { ?>
					<table  border="0" borderColor="#ccc" cellpadding="2" cellspacing="0"  >
						<tr>
							<td align="left" valign="middle" width="15%">
								<strong>Arrival On&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle"  >
								<?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_arrival_on']!=''){ echo date('d/m/Y',strtotime($voucherDetailData['h_arrival_on'])); }   ?> 
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
								<?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }  ?>
							</td> 
						</tr>
						<tr>
							<td align="left" valign="middle">
								<strong>Departure On&nbsp;:&nbsp;</strong>
							</td>
							<td align="left" valign="middle">
								<?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00 00:00:00' && $voucherDetailData['h_departure_on']!=''){ echo  $voucherDetailData['h_departure_on'] ; }   ?>
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
								<?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }   ?>
							</td>
						</tr>
					</table> 
					<!-- Notes and Billing INstructions --> 
					<br>
					<?php } ?>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<?php //if(!empty($voucherNotes)){ ?>
						<tr align="left" valign="top">
							<td colspan="3">
								<div  class="w100" ><strong>Notes&nbsp;:&nbsp;</strong><?php if(!empty($voucherNotes)){ echo ucfirst(strip($voucherNotes)); }else{ 
										echo $suppvoucherNotes['supplierVoucherNoteText']; 
									} ?></div><br>
								</td>
						</tr>
						<?php //} ?>
						<tr align="left" valign="top"  >
							<td colspan="3">
								<div  class="w100"><strong>Billing&nbsp;Instructions&nbsp;:&nbsp;</strong>
									<?php if(!empty($billingInstructions)){ echo ucfirst(strip($billingInstructions)); }else{ echo $suppvoucherNotes['supplierbillingInstructionText']; } ?></div>
							</td>
							<!-- or $billInstYes==0 -->
						</tr>
					</table>
				</td>
				</tr>
			</table>
			</div>  
			<?php 
		} 
	}

	// Hotel Voucher
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

		$g="";
		$g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
		$finalHotelData=mysqli_fetch_array($g);

		if(($serviceType == 'hotel' && $serviceId==$FID || $_REQUEST['allvoucher']!='' ) && $finalHotelData['manualStatus']==3 ){ 
			$c="";
			$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
			$hotelData=mysqli_fetch_array($c); 
			
			$rooms = '';
			if($quotationData['sglRoom'] > 0){ $rooms .= $quotationData['sglRoom']." SGL ,"; }
			if($quotationData['dblRoom'] > 0){ $rooms .= $quotationData['dblRoom']." DBL ,"; }
			if($quotationData['tplRoom'] > 0){ $rooms .= $quotationData['tplRoom']." TPL ,"; }
			if($quotationData['twinRoom'] > 0){ $rooms .= $quotationData['twinRoom']." TWIN ,"; }
			if($quotationData['extraNoofBed'] > 0){ $rooms .= $quotationData['extraNoofBed']." EBed(A) ,"; }
			if($quotationData['childwithNoofBed'] > 0){ $rooms .= $quotationData['childwithNoofBed']." CWBed ,"; }
			if($quotationData['childwithoutNoofBed'] > 0){ $rooms.= $quotationData['childwithoutNoofBed']." CNBed ,"; }
			if($quotationData['sixNoofBedRoom'] > 0){ $rooms .= $quotationData['sixNoofBedRoom']." SixBed, "; }
		if($quotationData['eightNoofBedRoom'] > 0){ $rooms .= $quotationData['eightNoofBedRoom']." EightBed, "; }
		if($quotationData['tenNoofBedRoom'] > 0){ $rooms .= $quotationData['tenNoofBedRoom']." TenBed, "; }
		if($quotationData['quadNoofRoom'] > 0){ $rooms .= $quotationData['quadNoofRoom']." Quad, "; }
		if($quotationData['teenNoofRoom'] > 0){ $rooms .= $quotationData['teenNoofRoom']." Teen, "; }
			
			$noOfRooms = $quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']+$quotationData['twinRoom']+$quotationData['extraNoofBed']+$quotationData['childwithNoofBed']+$quotationData['childwithoutNoofBed']+$quotationData['sixNoofBedRoom']+$quotationData['eightNoofBedRoom']+$quotationData['tenNoofBedRoom']+$quotationData['quadNoofRoom']+$quotationData['teenNoofRoom'];
			
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
			$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
			$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);
	   		$isShowSupCont = 0;
			$isShowSupCont = $suppvoucherNotes['supplierStatus']; 
			if($module=='ClientVoucher'){
				$ADStatus = $voucherDetailData['cli_ADStatus'];
			 	$voucherNotes = $voucherDetailData['cli_voucherNotes'];
			 	$billInstYes = $voucherDetailData['cli_billInstYes'];
			 	$billingInstructions = $voucherDetailData['cli_billingInstructions'];
			}else{
				$ADStatus = $voucherDetailData['sup_ADStatus'];
			 	$voucherNotes = $voucherDetailData['sup_voucherNotes'];
			 	$billInstYes = $voucherDetailData['sup_billInstYes'];
			 	$billingInstructions = $voucherDetailData['sup_billingInstructions'];
			}
			
			$showVocherNum = generateVoucherNumber($voucherId,$module,strtotime($fromDate));	
			?>
			<div class="sub-container"  width="700"  style="width:700px;font-size: 16px;font-family: sans-serif;<?php if($aspdf ==1){ ?>padding:10px 50px;<?php } ?>" >
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr><td>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					  <tr>
						<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px margin: 0 auto;" /></td>
					  </tr>
					</table>
				  	<br>
				  	<br>
				  	<br>
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
									<?php if($isShowSupCont == 1){ ?>
									<tr>
										<td align="left" >
										<?php if($contactPerson!=''){ ?>
											<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo strip($contactPerson); ?>&nbsp;&nbsp;&nbsp;&nbsp;
										<?php } ?>
											<strong>Phone&nbsp;:&nbsp;</strong><?php  echo $suppagentPone; ?>&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>Email&nbsp;:&nbsp;</strong><?php  echo $suppagentEmail; ?>
										</td>
									</tr>
									<?php } ?>
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
											<strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $totalPax; ?>
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
					<?php if ($ADStatus==1) { ?>
					<table  border="0" borderColor="#ccc" cellpadding="2" cellspacing="0"   >
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
					<?php } ?>
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<?php //if(!empty($voucherNotes)){ ?>
						<tr align="left" valign="top">
							<td colspan="3">
								<div  class="w100" ><strong>Notes&nbsp;:&nbsp;</strong><?php if(!empty($voucherNotes)){ echo ucfirst(strip($voucherNotes)); }else{ 
										echo $suppvoucherNotes['supplierVoucherNoteText']; 
									} ?></div><br>
								</td>
						</tr>
						<?php //} ?>
						<tr align="left" valign="top">
							<td colspan="3">
								<div class="w100"><strong>Billing&nbsp;Instructions&nbsp;</strong><?php if(!empty($billingInstructions)){ echo ucfirst(strip($billingInstructions)); }else{ echo $suppvoucherNotes['supplierbillingInstructionText']; } ?></div>
							</td>
							<!-- or $billInstYes==0 -->
						</tr>
					</table>  
					</td>
					</tr>
				</table>
			</div> 
			<br>
			<?php
			$cnt1++;		 
		}
		}
	} 
} //endofloop
} 
?>   
</div>
