
<?php 
include "inc.php"; 
if($_REQUEST['string']!=''){
	$postArray = explode("_", trim($_REQUEST['string']));
	$supplierStatusId = $postArray['0'];
	$serviceId = $postArray['1'];
	$serviceType = $postArray['2'];
	$voucherModule = $postArray['3'];
	$quotationId = $postArray['4'];
	$aspdf = $postArray['5'];
	
	$fqssQuery = ' and startDate in ( select startDate from finalquotationItinerary where id="'.$supplierStatusId.'") ';
}elseif($_REQUEST['allvoucher']!=''){
	$postArray = explode("_", trim($_REQUEST['allvoucher']));
	$quotationId = $postArray['0'];
	$voucherModule = $postArray['1']; //'ClientVoucher';
	$aspdf = $postArray['2']; //1,0;
	$fqssQuery = ' ';
}else{
	$supplierStatusId = $_REQUEST['supplierStatusId'];

	$serviceId = $_REQUEST['serviceId'];
	$serviceType = $_REQUEST['serviceType'];
	$voucherModule = $_REQUEST['module'];
	$quotationId =$_REQUEST['quotationId'];
	$aspdf = 0;
	$fqssQuery = ' and startDate in ( select startDate from finalquotationItinerary where id="'.$supplierStatusId.'") ';
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
?><div class="main-container" style="width:800px;font-size: 16px;font-family: sans-serif;">
<?php  
if ($voucherModule=='ClientVoucher'){
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
} 
// for hotel only  
$dateSets = getHotelDateSets($quotationId,0);
$dateSetArray = explode('~',$dateSets);
$cnt1 = 1; 
if(strlen($dateSets) > 0){ 
	foreach($dateSetArray as $dateSet){
		
		$dateSetData = explode('^',$dateSet);
		$hotelId = $dateSetData[0];
		$fromDate = $dateSetData[1];
		$toDate = $dateSetData[2];
		$FID = $dateSetData[3];
		$supplierStatusId = $FID;

		$suppStatusId_cnt = strip($supplierStatusId."_".$cnt1);
		
		$g="";
		$g=GetPageRecord('*','finalQuote','id="'.$FID.'"'); 
		$finalHotelData=mysqli_fetch_array($g);
		
		if(($serviceType == 'hotel' && $serviceId==$FID || $_REQUEST['allvoucher']!='' ) && $finalHotelData['manualStatus']==3 ){ 
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

		if($quotationData['sixNoofBedRoom'] > 0){ $rooms .= $quotationData['sixNoofBedRoom']." SixBed, "; }
		if($quotationData['eightNoofBedRoom'] > 0){ $rooms .= $quotationData['eightNoofBedRoom']." EightBed, "; }
		if($quotationData['tenNoofBedRoom'] > 0){ $rooms .= $quotationData['tenNoofBedRoom']." TenBed, "; }
		if($quotationData['quadNoofRoom'] > 0){ $rooms .= $quotationData['quadNoofRoom']." Quad, "; }
		if($quotationData['teenNoofRoom'] > 0){ $rooms .= $quotationData['teenNoofRoom']." Teen, "; }
			
			$noOfRooms = $quotationData['sglRoom']+$quotationData['dblRoom']+$quotationData['tplRoom']+$quotationData['twinRoom']+$quotationData['extraNoofBed']+$quotationData['childwithNoofBed']+$quotationData['childwithoutNoofBed']+$quotationData['sixNoofBedRoom']+$quotationData['eightNoofBedRoom']+$quotationData['tenNoofBedRoom']+$quotationData['quadNoofRoom']+$quotationData['teenNoofRoom'];
			$g="";
			$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotationHotelData['mealPlan'].'"'); 
			$mealData=mysqli_fetch_array($g); 
			//.'-'.$mealData['subname']
			$mealplan = $mealData['name'];
			// Hotel Contact Person
			$hotcpm = GetPageRecord('*','hotelContactPersonMaster','corporateId="'.$hotelData['id'].'" and division=3');
			$hotelcpmData=mysqli_fetch_assoc($hotcpm);

			$CheckIn = "CheckIn :".date('d M Y',strtotime($fromDate));
			$CheckOut = " CheckOut :".date('d M Y',strtotime($toDate));
			$date1 = new DateTime($fromDate);
			$date2 = new DateTime($toDate);
			$interval = $date1->diff($date2);
			$nights = $interval->days;   
			
			$confNO  = $finalHotelData['confirmationNo'];
			
			// add or update voucher details
			$voucherQuery="";
			$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusId.'" and serviceType="hotel" and serviceId="'.$FID.'" and quotationId="'.$quotationId.'"'); 
			$voucherDetailData = mysqli_fetch_array($voucherQuery);
			$voucherId  = $voucherDetailData['id'];	
			$voucherDate2  = date('j M Y',strtotime($voucherDetailData['voucherDate']));
			
			$vouchersetting = GetPageRecord('*','voucherSettingMaster','id=1');
			$suppvoucherNotes = mysqli_fetch_assoc($vouchersetting);
	   		

			$showVocherNum = generateVoucherNumber($voucherId,$voucherModule,strtotime($fromDate));
			?><div class="sub-container"  width="700"  style="width:700px;font-size: 16px;font-family: sans-serif;<?php if($aspdf ==1){ ?>padding:10px 50px;<?php } ?>" ><table width="700" border="2" cellpadding="15" cellspacing="0">
			  <tr>
				<td><table width="100%" border="0" cellpadding="0" cellspacing="0" >
					  <tr>
						<td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px margin: 0 auto;" /></td>
					  </tr>
					</table>
				  	<br>
				  	<br>
				  	<br><table width="100%" border="0" cellpadding="0" cellspacing="0" >
					  <tr>
						<td width="40%"><table>
						<tr>
							  <td  align="left" style="font-size: 16px;"><strong>To:&nbsp;</strong>  <strong> <?php echo strip($suppData['name'] ); ?> </strong></td>
							</tr>
							<tr>
							  <td align="left"><strong>Address&nbsp;:&nbsp;</strong> <?php echo strip($supplierAddData['address']); ?> </td>
							</tr>
							<tr>
							  <td align="left"><strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong> <?php echo strip($resListing['contactPerson']); ?> </td>
							</tr>
							<tr>
							  <td align="left"><strong>Phone&nbsp;:&nbsp;</strong> <?php echo decode($resListing['phone']); ?> </td>
							</tr>
							<tr>
							  <td align="left"><strong>Email&nbsp;:&nbsp;</strong> <?php echo decode(strip($resListing['email'])); ?> </td>
							</tr>
						</table></td>
						<td width="30%"><table>
							<tr>
							  <td  align="left"><strong>Tour No&nbsp;:&nbsp;</strong> <?php echo $tourId; ?> </td>
							</tr>
							<tr>
							  <td align="left"><strong>Tour Date&nbsp;:&nbsp;</strong> <?php echo date('d/m/Y', strtotime($resultpage['fromDate']) ); ?> </td>
							</tr>
							<tr>
							  <td align="left"><strong>Total&nbsp;Pax:&nbsp;:&nbsp;</strong> <?php echo $pax; ?> </td>
							</tr>
							<tr>
							  <td  align="left"><strong>Booking No:</strong> <?php echo $bookingId; ?> </td>
							</tr>
						</table></td>
					  </tr>
					  <tr><td colspan="2">&nbsp;</td></tr>
					</table><!-- manually voucher no and date --><table width="100%" border="0" cellspacing="0" bordercolor="#ccc" cellpadding="0">
					  <tr>
						<td width="34%"><strong>Voucher&nbsp;No. </strong> </td>
						<td width="33%"><strong>Voucher&nbsp;Date</strong> </td>
						<td width="33%"><strong>Reference&nbsp;No.</strong> </td>
					  </tr>
					  <tr>
						<td><?php echo $showVocherNum; ?></td>
						<td><?php if($voucherDate2!='1970-01-01 00:00:00' && $voucherDate2!='0000-00-00' && $voucherDate2!=''){ echo date('j M Y', strtotime($voucherDate2)); }else{ echo date('j M Y',strtotime($fromDate)); } ?></td>
						<td><?php echo $resultpage['referanceNumber']; ?></td>
					  </tr>
					</table>
				  
					<!--In favour of:-->

					<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					  <tr>
						<td width="34%"><strong>In favour of:</strong></td>
						<td width="33%"><?php echo $leadPaxName; ?></td>
						<td ><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; } ?></td>
					  </tr>
					</table>
				  
					<!--In favour of:-->
					<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					  <tr>
						<td width="34%"><strong>Lead&nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</strong></td>
						<td width="33%"><span style="width:97%;padding:3px; "><?php echo strip($resultpage['leadPaxName']);?></span></td>
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
					while($editresult2=mysqli_fetch_array($rs12)){
					?>
					<tr>
					<td width="73%"><?php echo $editresult2['otherGuestName']; ?></td>
					<td width="27%" align="center"><i class="fa fa-trash" aria-hidden="true" style="font-size: 13px; color: red; cursor:pointer;" onclick="delother('<?php echo $editresult2['id']; ?>','<?php echo $editresult2['supplierStatusId']; ?>');"></i></td>
					</tr>
					<?php } ?>
					</table>
					<?php
					}
					?>
					</div> 
					
						<!-- Hotel Information -->
						<div style="width: 100%;">
					<div style="padding-bottom:5px;"><strong>
						<?php echo $hotelData['hotelName']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
						$ppres = GetPageRecord('*','proposalSettingMaster','proposalNum=6');
						$starcolor = mysqli_fetch_assoc($ppres);

						$cres = GetPageRecord('*','hotelCategoryMaster','id="'.$hotelData['hotelCategoryId'].'"');
						$catres = mysqli_fetch_assoc($cres);
						$hotelStar = $catres['hotelCategory'];
							 for($i=1; $i<=$hotelStar; $i++ ){
								// echo '';
								
								?>
								
								<!-- <i style="font-size: 16px;vertical-align:bottom; color:<?php if($starcolor['proposalColor']!=''){ echo $starcolor['proposalColor']; }else{ echo '#dcff2e'; } ?>;" class="fa fa-star" aria-hidden="true"></i> -->
								<img style="vertical-align: bottom;" src="<?php echo $fullurl; ?>/images/hotelStar.png" alt="Hotel Star" width="18" height="18">
								
								<?php
							 } 
							 ?>
							 </strong>
						</div>
						
						<div style="width:9%; display:inline-block;padding-bottom:5px;"><strong>Address:</strong></div>
							<div style="width:90%; display:inline-block;"><?php echo $hotelData['hotelAddress']; ?></div>
							<div style="width:14%; display:inline-block;padding-bottom:5px;"><strong> Website URL:</strong></div>
							<div style="width:85%; display:inline-block;"><?php echo $hotelData['url']; ?></div>
						
							<div style="width:16%; display:inline-block;padding-bottom:10px;"><strong> Contact Person:</strong></div>
							<div style="width:24%; display:inline-block;"><?php echo $hotelcpmData['contactPerson']; ?></div>
							<div style="width:8%; display:inline-block;"><strong>Phone:</strong></div>
							<div style="width:15%; display:inline-block;"><?php echo $hotelcpmData['phone']; ?></div>
							<div style="width:8%; display:inline-block;"><strong>Email:</strong></div>
							<div style="width:27%; display:inline-block;"><?php echo $hotelcpmData['email']; ?></div>
					</div>
					<!-- Services Date -->

					<table width="99%" border="1" cellpadding="3" cellspacing="0" >
					  <tr>
						<td width="36%"><strong>Services:</strong></td>
						<td width="64%"><strong>Please provide the services as per the following.</strong></td>
					  </tr>
					</table>
					<!-- Service date wise list -->
					<table width="99%" border="1" cellspacing="0" bordercolor="#ccc" cellpadding="4">
					<tr>
						<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" width="5%" align="center" rowspan="3"><?php echo 1; ?></td>
						<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" width="31%"><?php echo strip($hotelData['hotelName']); ?></td>
						<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px"><?php echo $CheckIn;?></td>
						<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px"><?php echo $CheckOut; ?></td>
						<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px"><?php echo $nights." Night(s)"; ?></td>
				 	</tr>
				  	<tr>
						<td ><?php echo "Confirmation Number" ?></td>
						<td colspan="4"><strong><?php echo $confNO; ?></strong></td>
					</tr>
					  	<?php  
						$g2="";
						$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate',_QUOTATION_HOTEL_MASTER_,' quotationId="'.$quotationId.'" and  supplierId="'.$hotelId.'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" group by roomType,mealPlan  order by fromDate asc'); 
						if(mysqli_num_rows($g2)>0){ 
						while($quotMealData=mysqli_fetch_array($g2)){ 
							
							
							$g="";
							$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$quotMealData['roomType'].'"'); 
							$roomTypeData=mysqli_fetch_array($g);
							$rType=$roomTypeData['name'];
							
							$g="";
							$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$quotMealData['mealPlan'].'"'); 
							$mealData=mysqli_fetch_array($g); 
							//.'-'.$mealData['subname']
							$mealplan = $mealData['name'];
							?>
					  <tr>
						<td colspan="5"><table width="100%" border="1" cellpadding="0" cellspacing="0" >
							<tr  >
							  <th  align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Date</strong></th>
							  <th  align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Room Type/No. of Rooms</strong></th>
							  <th  align="center" bgcolor="#133f6d" style="color:#ffffff;"><strong>Meal Plan</strong></th>
							</tr>
							<tr>
							  <td  align="center" width="32%"><?php echo date('d M',strtotime($quotMealData['fromDate']))." - ".date('d M Y',strtotime($quotMealData['toDate']) + 86400); ?></td>
							  <td  align="center" >&nbsp;&nbsp;<?php echo $rType.' / '.$rooms.' '.'Total Rooms='.$noOfRooms;?></td>
							  <td align="center" width="10%"><?php echo $mealplan; if($quotMealData['lunch']>0 && $quotMealData['complimentaryLunch']==1){ echo ", Lunch"; } if($quotMealData['dinner']>0 && $quotMealData['complimentaryDinner']==1){echo ", Dinner"; } if($quotMealData['breakfast']>0 && $quotMealData['complimentaryBreakfast']==1){echo ", Breakfast"; } ?></td>
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
					<table width="100%" border="1" bordercolor="#ccc" cellpadding="4" cellspacing="0" >
					<tr>
						<td align="left" valign="middle" width="15%"><strong>Arrival On </strong> </td>
						<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; ">
						  <?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("j M Y", strtotime($fromDate));}   ?>
						</span> </td> 
						<td align="left" valign="middle"  ><strong>From</strong> </td>
						<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; "><?php echo strip($voucherDetailData['h_from']); ?></span> </td>
						
						<td align="left" valign="middle"  ><strong>By </strong> </td>
						<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; "><?php echo strip($voucherDetailData['h_by_from']); ?></span> </td>
						
						<td align="left" valign="middle"  ><strong>At </strong> </td>
						<td align="left" valign="middle"  ><span style="width:97%;  padding:3px; ">
						  <?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?>
						</span> </td>
					  </tr>
					  <tr>
						<td align="left" valign="middle"><strong>Departure On </strong> </td>
						<td align="left" valign="middle"><span style="width:97%;  padding:3px; ">
						  <?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("j M Y", strtotime($toDate));}   ?>
						</span> </td> 
						<td align="left" valign="middle"><strong>To </strong> </td>
						<td align="left" valign="middle"><span style="width:97%;  padding:3px; "><?php echo strip($voucherDetailData['h_to']); ?></span> </td>
							<td align="left" valign="middle"><strong>By </strong> </td>
						<td align="left" valign="middle"><span style="width:97%;  padding:3px; "><?php echo strip($voucherDetailData['h_by_to']); ?></span> </td>
						<td align="left" valign="middle"><strong>At </strong> </td>
						<td align="left" valign="middle"><span style="width:97%;  padding:3px; ">
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
						<td colspan="3"><div class="griddiv">
							<label><strong>Notes</strong><br>
							  <?php if(!empty($voucherDetailData['voucherNotes'])){ echo strip($voucherDetailData['voucherNotes']); }else{ echo $suppvoucherNotes['clientVoucherNoteText'] ; } ?>
							</label>
						</div></td>
					  </tr>
					  <?php //if($voucherDetailData['billInstYes']==0){ ?> 
					  <tr align="left" valign="top">
						<td colspan="3"><div class="griddiv">
							<label>
								<strong>Billing Instructions</strong><br>
								<?php if(!empty($voucherDetailData['billingInstructions'])){ 
									echo strip($voucherDetailData['billingInstructions']); 
									}else{ echo $suppvoucherNotes['clientbillingInstructionText']; 
									} ?> 
							</label>
						</div></td>
					  </tr>
					  <?php //} ?>
				  	</table>
				</td>
			  </tr>
			</table>
			</div><br><?php
		}
		$cnt1++;		 
	}
}


// other vouchers 
if($serviceType == 'other' && $serviceId==0 || $_REQUEST['allvoucher']!='' ){ 
	$qIQuery2='';  
	$qIQuery2=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'"and totalPax="'.$slabId.'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteVisa where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuotePassport where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteInsurance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) )  group by startDate order by startDate asc');


	if(mysqli_num_rows($qIQuery2) > 0){	
		$cnt=0;
		while($finalIt_Data2=mysqli_fetch_array($qIQuery2)){ 

			$supplierStatusId = $finalIt_Data2['id'];
		 	// add or update voucher details
			$voucherQuery="";
			$voucherQuery=GetPageRecord('*','voucherDetailsMaster','supplierStatusId="'.$supplierStatusId.'" and serviceType="other" and serviceId=0 and quotationId="'.$quotationId.'"');  
			$voucherDetailData = mysqli_fetch_array($voucherQuery);
			$voucherId  = $voucherDetailData['id'];	
			$queryfromDate2  = date('j M Y',strtotime($voucherDetailData['voucherDate']));
			
			$showVocherNum = generateVoucherNumber($voucherId,$voucherModule,strtotime($queryfromDate));	
		 	$suppStatusId_cnt = $supplierStatusId;
			?>
            
            <div class="sub-container" width="700" style="width:710px;font-size: 11px;font-family: sans-serif; padding:10px 50px;" >
            
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
                <td align="center" width="100%">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" >
						<tr><td align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo $masterProposalLogo; ?>" style="width:544px;height:85px;margin: 0 auto;" /></td></tr>
					</table><br><br>
                    
                    <table border="0" cellpadding="0" cellspacing="0" >
						<tr>
							<td width="60%">
							    <table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td align="left" style="font-size: 14px;">
											<strong>To:</strong>
											<strong><?php echo strip($suppData['name'] ); ?></strong>
										</td>
									</tr>
									<tr>
										<td align="left">
											<strong>Address&nbsp;:&nbsp;</strong>
											<?php echo strip($supplierAddData['address']); ?>
										</td>
									</tr>
									<tr>
										<td align="left">
											<strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong>
											<?php echo strip($resListing['contactPerson']); ?> </td>
									</tr>
									<tr>
										<td align="left">
											<strong>Phone&nbsp;:&nbsp;</strong>
											<?php echo decode($resListing['phone']); ?>
										</td>
									</tr>
									<tr>
										<td align="left">
											<strong>Email&nbsp;:&nbsp;</strong>
											<?php echo decode(strip($resListing['email'])); ?> </td>
									</tr>
								</table>
							</td>
							<td width="40%">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
										<td align="right">
											<strong>Tour No&nbsp;:&nbsp;</strong>
											<?php echo $tourId; ?>
										</td>
									</tr>
									<tr>
										<td align="right">
											<strong>Tour Date&nbsp;:&nbsp;</strong>
											<?php echo date('d/m/Y', strtotime($resultpage['fromDate']) ); ?>
										</td>
									</tr>
									<tr>
										<td align="right">
											<strong>No&nbsp;Of&nbsp;Pax&nbsp;:&nbsp;</strong>
											<?php echo $pax; ?>
										</td>
									</tr> 
									<tr>
										<td  align="right">
											<strong>Booking No:</strong>
											<?php echo $bookingId; ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<br /> <br />
					<!-- manually voucher no and date -->
					<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="5">
						<tr>
							<td width="50%" align="left">
								<strong>Voucher&nbsp;No.</strong>
							</td>
							<td width="30%" align="left">
								<strong>Voucher&nbsp;Date</strong>
							</td>
							<td  width="20%" align="left">
								<strong>Reference&nbsp;No.</strong>
							</td> 
						</tr>

						<tr> 
							<td width="50%" align="left"> <?php echo $showVocherNum; ?> 
							</td>
							<td width="30%" align="left"><?php if($queryfromDate2!='1970-01-01' && $queryfromDate2!='0000-00-00' && $queryfromDate2!=''){ echo date('j M Y', strtotime($queryfromDate2)); }else{ echo date('j M Y',strtotime($queryfromDate)); } ?>
							</td>
							<td width="20%" align="left">
								<?php echo $resultpage['referanceNumber']; ?>
							</td> 
						</tr >

					</table>
					<br /><br />

					<!--In favour of:--> 
					<table width="100%" border="1" cellpadding="5" cellspacing="0" >
						<tr> 
							<td width="50%" align="left"><strong>In favour of:</strong></td>
							<td width="30%" align="left"><?php echo $leadPaxName; ?></td>
							<td width="20%" align="left"><?php echo $quotationData['adult']." Adult(s)" ; if($quotationData['child']>0 || $quotationData['child']=''){ echo ', '.$quotationData['child']." Child(s)"; } ?></td>
						</tr>
					</table>
					
					<!--In favour of:--> 
					<table width="100%" border="0" cellpadding="5" cellspacing="0" >
					   <tr>
						  <td width="50%" align="left"><strong>Lead&nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</strong></td>
						  <td width="30%" align="left"><span style="width:140px;  padding:3px; "><?php echo strip($resultpage['leadPaxName']);  ?></span></td>
						  <td >&nbsp;</td>
					   </tr>
					</table> 
					<br />

					<div id="addotherGuest<?php echo $suppStatusId_cnt;?>">
						<table width="55%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="margin-top:5px;">
						<?php 
						$rs12=""; 
						$rs12=GetPageRecord('*','otherLeadPaxDetails','quotationId="'.$quotationId.'" and supplierStatusId="'.$suppStatusId_cnt.'"');  
						while($editresult2=mysqli_fetch_array($rs12)){
						?>
						<tr>
						<td width="73%"><?php echo $editresult2['otherGuestName']; ?></td>
						<td width="27%" align="center"><i class="fa fa-trash" aria-hidden="true" style="font-size: 13px; color: red; cursor:pointer;" onclick="delother('<?php echo $editresult2['id']; ?>','<?php echo $editresult2['supplierStatusId']; ?>');"></i></td>
						</tr>
						<?php } ?>
						</table>
					</div>
					
					<!-- Services Date -->
					<table width="100%" border="0" cellpadding="5" cellspacing="0" >
						<tr> 
							<td width="17%" align="left"><strong>Services:</strong></td>
							<td width="80%" align="left"><strong>Please provide the services as per the following.</strong></td> 
						</tr>
					</table> <br />
					<br />
								<!-- Value Added Services Block Starts -->
				
				<br>
				<?php $VBRC = GetPageRecord('*','finalQuoteVisa','quotationId="'.$quotationData['id'].'" and manualStatus=3 order by id desc');
				if(mysqli_num_rows($VBRC)>0){ ?>
				<div><strong>VISA Details</strong></div>
				<table width="100%" border="1" cellpadding="0" cellspacing="0">
					<tr>
					<th align="left" width="30%">Visa Name</th>
					<th align="left" width="30%">Visa Type</th>
					<th align="left">Adult</th>
					<th align="left">Child</th>
					<th align="left">Infant</th>
					</tr>
				
				<?php
				
				while($visaQuoteData = mysqli_fetch_array($VBRC)){

				 $rsV = GetPageRecord('*',_VISA_TYPE_MASTER_,'id="'.$visaQuoteData['visaTypeId'].'"');
				 $visaType = mysqli_fetch_array($rsV);
				?>
				<tr>
					<td align="left"><?php echo $visaQuoteData['name'] ?></td>
					<td align="left"><?php echo $visaType['name'] ?></td>
					<td align="left"><?php echo $visaQuoteData['adultPax'] ?></td>
					<td align="left"><?php echo $visaQuoteData['childPax'] ?></td>
					<td align="left"><?php echo $visaQuoteData['infantPax'] ?></td>
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
					<th align="left" width="30%">Passport Name</th>
					<th align="left" width="30%">Passport Type</th>
					<th align="left">Adult</th>
					<th align="left">Child</th>
					<th align="left">Infant</th>
					</tr>
				
				<?php
				
				while($passportQuoteData = mysqli_fetch_array($PRS)){

				 $rsP = GetPageRecord('*',_PASSPORT_TYPE_MASTER_,'id="'.$passportQuoteData['passportTypeId'].'"');
				 $passportType = mysqli_fetch_array($rsP);
				?>
				<tr>
					<td align="left"><?php echo $passportQuoteData['name'] ?></td>
					<td align="left"><?php echo $passportType['name'] ?></td>
					<td align="left"><?php echo $passportQuoteData['adultPax'] ?></td>
					<td align="left"><?php echo $passportQuoteData['childPax'] ?></td>
					<td align="left"><?php echo $passportQuoteData['infantPax'] ?></td>
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
					<th align="left" width="30%">Insurance Name</th>
					<th align="left" width="30%">Insurance Type</th>
					<th align="left" >Adult</th>
					<th align="left">Child</th>
					<th align="left">Infant</th>
					</tr>
				
				<?php
				
				while($insuranceQuoteData = mysqli_fetch_array($PRS)){

				 $rsI = GetPageRecord('*',_INSURANCE_TYPE_MASTER_,'id="'.$insuranceQuoteData['insuranceTypeId'].'"');
				 $insuranceType = mysqli_fetch_array($rsI);
				?>
				<tr>
					<td align="left"><?php echo $insuranceQuoteData['name'] ?></td>
					<td align="left"><?php echo $insuranceType['name'] ?></td>
					<td align="left"><?php echo $insuranceQuoteData['adultPax'] ?></td>
					<td align="left"><?php echo $insuranceQuoteData['childPax'] ?></td>
					<td align="left"><?php echo $insuranceQuoteData['infantPax'] ?></td>
				</tr>
				<?php

			}
			?>
			</table>
			<?php } ?>
			<br>
			<!-- Value Added Services Block Ends -->
					<!-- Service date wise list -->
					<table width="100%" border="1" cellspacing="0" cellpadding="5" borderColor="#ccc"   style="font-size:13px;"> 
						
						<!-- services loop without hotel-->
						<?php  
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
						$qIQuery=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$quotationData['id'].'" and ( serviceId in ( select id from finalQuotetransfer where quotationId="'.$quotationData['id'].'"and totalPax="'.$slabId.'"  and manualStatus=3 ) or serviceId in ( select id from finalQuoteEntrance where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFerry where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteActivity where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteTrains where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteFlights where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) or serviceId in ( select id from finalQuoteGuides where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteExtra where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteMealPlan where quotationId="'.$quotationData['id'].'" and manualStatus=3 )  or serviceId in ( select id from finalQuoteEnroute where quotationId="'.$quotationData['id'].'" and manualStatus=3 ) ) and startDate="'.$finalIt_Data2['startDate'].'" order by srn asc');
						while($finalIt_Data=mysqli_fetch_array($qIQuery)){
			 
							if($finalIt_Data['serviceType'] == 'transfer' || $finalIt_Data['serviceType'] == 'transportation'){ 
			
								$transferQuery='';    
								$transferQuery=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" and totalPax="'.$slabId.'" order by fromDate asc ');  
								while($finalQuoteTransfer=mysqli_fetch_array($transferQuery)){
									$transferFlag = 1;
									
									$c="";  
									$c=GetPageRecord('*','packageBuilderTransportMaster','id="'.$finalQuoteTransfer['transferId'].'"'); 
									$transferData=mysqli_fetch_array($c);
									
									$d=GetPageRecord('*','quotationTransferMaster','id="'.$finalQuoteTransfer['transferQuotationId'].'"'); 
									$transferQuoteData=mysqli_fetch_array($d);
									 
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
											$startTime24Set = $endTime24Set = $pickupTime24Set = $arrivalFrom = $pickupAddress = $dropAddress = $airportName =$byMode =  $modeName = $modeNumber = '';


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
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" colspan="4" >
													<strong>Transport&nbsp;Name</strong>
												</td> 
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>Confirmation&nbsp;No.</strong>
												</td>
											</tr>
											<tr> 
												<td colspan="4" valign="middle"><?php echo strip($transferData['transferName'])." | ".$vehicleBrandData['name']." | ".$vehicleData['model']; ?></td> 
												<td ><strong><em><?php echo strip($finalQuoteTransfer['confirmationNo']); ?></em></strong></td>
											</tr>
											<tr>
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>Arrival&nbsp;From</strong>									
												</td>
												<td  bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>By&nbsp;Mode</strong>									
												</td>
												<td  bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong><?php if($byMode =='flight'){ echo "Flight"; } else{ echo "Train"; } ?>&nbsp;Name</strong>									</td>
												<td  bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong><?php if($byMode =='flight'){ echo "Flight"; } else{ echo "Train"; } ?>&nbsp;Number</strong>									</td>
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" >
													<strong>Arv/Dpt&nbsp;Time</strong>									
												</td>
											</tr>
											<tr>
												<td><?php echo strip($arrivalFrom); ?></td> 
												<td><?php echo ucfirst($byMode); ?></td> 
												<td><?php echo strip($modeName); ?></td> 
												<td><?php echo $modeNumber; ?></td> 
												<td><?php echo $startTime24Set; ?></td> 
											</tr>
											<tr>
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" >
													<strong>Pickup&nbsp;Time</strong>									
												</td>
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>Drop Time</strong>
												</td>
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>Airport&nbsp;Name</strong>
												</td>
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>Pickup&nbsp;Address</strong>
												</td>
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>Drop&nbsp;Address</strong>
												</td>
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
								$ferryQuery=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'" and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
								while($finalQuoteFerry=mysqli_fetch_array($ferryQuery)){
									 
									//quotationId = "'.$quotationData['id'].'" and
									$ccc="";
										$ccc=GetPageRecord('*','quotationFerryMaster','id="'.$finalQuoteFerry['ferryQuotationId'].'"'); 
									$TimeData=mysqli_fetch_array($ccc);	 

									$dddd="";
										$dddd=GetPageRecord('*','ferryClassMaster','id="'.$TimeData['ferryClass'].'"'); 
									$ferryClassname=mysqli_fetch_array($dddd);
									
									$dd="";
									$dd=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerry['ferryId'].'"'); 
									$ferryData=mysqli_fetch_array($dd);
			
									?>  
									<tr>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" >
											<strong>Ferry&nbsp;Name</strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" width="35%">
											<strong>Seat&nbsp;Type </strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Arrival&nbsp;Time/Departure&nbsp;Time</strong>
										</td>
										
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
									</tr>
									<tr> 
									<td>Ferry : <?php echo strip($ferryData['name']); ?></td> 
									<td><?php echo strip($ferryClassname['name']); ?></td> 
									<td><?php echo $TimeData['pickupTime']; ?>/<?php echo $TimeData['dropTime']; ?></td> 
									<td style="font-size:16px"><strong><em> <?php echo strip($finalQuoteFerry['confirmationNo']); ?></em></strong></td>
									</tr>
									<?php 
								 }  
							}

							// Ferry mail body voucher here
			
							if($finalIt_Data['serviceType'] == 'entrance'){ 
								$entranceQuery='';   
								$entranceQuery=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'"  and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
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
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" >
											<strong>Entrance&nbsp;Name</strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Start&nbsp;Time</strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>End&nbsp;Time</strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
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
								$activityQuery=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'"  and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
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
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" >
											<strong>Activity&nbsp;Name</strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Start&nbsp;Time</strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>End&nbsp;Time</strong>
										</td>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
									</tr>
									<tr> 
										<td><?php echo strip($activityData['otherActivityName']); ?></td> 
										<td><?php echo $startTime24Set; ?></td> 
										<td><?php echo $endTime24Set; ?></td> 
										<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteActivity['confirmationNo']); ?></em></strong></td>
									</tr>
									<?php 
									$cnt++;
								}   
							}
						 
							if($finalIt_Data['serviceType'] == 'train'){ 
								$trainFlag=1;
								$trainQuery='';   
								$trainQuery=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'"  and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
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
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px"colspan="3">
													<strong>Train&nbsp;Name</strong>
												</td> 
												<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
													<strong>Confirmation&nbsp;No.</strong>
												</td>
											</tr>
											<tr> 
												<td colspan="3"><?php echo strip($trainName); echo "&nbsp;/Journey&nbsp;Type - ".$journeyType; ?></td>  
												<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteTrains['confirmationNo']); ?></em></strong></td>
											</tr>
											<tr>  
												<td width="25%" >
													<strong>Train&nbsp;Number</strong>									
												</td>
												<td  width="25%">
													<strong>Departure&nbsp;From</strong>									
												</td> 
												<td width="25%" >
													<strong>Arrival&nbsp;To</strong>									
												</td> 
												<td  width="25%">
													<strong>Train&nbsp;Class</strong>									
												</td>
											</tr>
											<tr> 
												<td><?php echo $trainNumber; ?></td> 
												<td><?php echo strip($departureFrom); ?></td> 
												<td><?php echo strip($arrivalTo); ?></td> 
												<td><?php echo $trainClass; ?></td> 
											</tr>
											<tr>
												<td >
													<strong>Departure&nbsp;Date</strong>
												</td>
												<td >
													<strong>Departure&nbsp;Time</strong>
												</td>
												<td >
													<strong>Arrival&nbsp;Date</strong>
												</td>
												<td >
													<strong>Arrival&nbsp;Time</strong>
												</td>
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
								$flightQuery=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'"  and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
								 
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
											 
											$c1=GetPageRecord('*','flightTimeLineMaster',' flightQuoteId="'.$finalQuoteFlights['flightQuotationId'].'" and quotationId="'.$finalQuoteFlights['quotationId'].'" and dayId="'.$finalQuoteFlights['dayId'].'"');
						$timeData = mysqli_fetch_assoc($c1);
											?>
											<table width="100%" border="1" cellspacing="0" borderColor="#ccc" cellpadding="5" style="font-size:13px;"> 
										
										
											<tr bgcolor="#F3F3F3">
										<td width="20%" >
												<strong>Flight&nbsp;Name</strong>									
										</td>
											<td width="20%" >
												<strong>Flight&nbsp;Number</strong>									
											</td>
											
											<td  width="30%">
												<strong>Flight&nbsp;Class</strong>									
											</td>
											
											<td width="30%">
												<strong>Confirmation&nbsp;No.</strong>
											</td>
										</tr>
										<tr> 
										<td><?php echo strip($flightData['flightName']); ?></td>  
										<td><?php echo $flightNumber; ?></td> 
											
										<td><?php echo $flightClass; ?></td> 
										<td style="font-size:16px"><strong><em><?php echo strip($finalQuoteFlights['confirmationNo']); ?></em></strong></td>
										</tr>
											<tr bgcolor="#F3F3F3">
										<td >
												<strong>From&nbsp;</strong>
											</td>
											<td >
												<strong>To&nbsp;</strong>
											</td>
											<td >
												<strong>Flight&nbsp;Date</strong>
											</td>
											<td >
												<strong>Flight&nbsp;Time</strong>
											</td>
											
										</tr>
										<tr> 

											<td><?php echo $departureFrom; ?></td> 
											<td><?php echo $arrivalTo; ?></td> 
											<td><?php if($timeData['departureDate']!='' && $timeData['departureDate']!='0000-00-00 00:00:00'){ echo date('d-m-Y',strtotime($timeData['departureDate'])); } ?></td> 
											<td><?php if($timeData['departureTime']!='' && $timeData['departureDate']!='0000-00-00 00:00:00'){ echo date('H:i:s',strtotime($timeData['departureTime'])); } ?></td> 
										</tr>
											</table>
										</td>
									</tr>
									<?php  
								}  
							} 
			
							if($finalIt_Data['serviceType'] == 'mealplan'){
								$mealPlanQuery='';   
								$mealPlanQuery=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'"  and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
								while($finalQuoteMealPlan=mysqli_fetch_array($mealPlanQuery)){		
									 
									?> 
									<tr>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" colspan="3">
											<strong>Service&nbsp;Name</strong>
										</td> 
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
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
								$additionalQuery=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'"  and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'" order by fromDate asc '); 
							 
								while($finalQuoteadditionalD=mysqli_fetch_array($additionalQuery)){
								
									$groupCost = $finalQuoteadditionalD['groupCost'];
									$c=GetPageRecord('*','extraQuotation','id="'.$finalQuoteadditionalD['additionalId'].'"'); 
									$additionalData=mysqli_fetch_array($c);	  
									?>
									<tr>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px"  colspan="3" >
											<strong>Service&nbsp;Name</strong>
										</td> 
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
									</tr>
									<tr> 
										<td colspan="3" ><?php echo strip($additionalData['name']); ?></td>  
										<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteadditionalD['confirmationNo']); ?></em></strong></td>
									</tr>
									<?php
								}  
							} 
						  
						 
							if($finalIt_Data['serviceType'] == 'guide'){
						 
			
								$guideQuery=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'"  and manualStatus=3 and id="'.$finalIt_Data['serviceId'].'"   order by fromDate asc ');  
								while($finalQuoteGuides=mysqli_fetch_array($guideQuery)){
							 
									$c=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,'id="'.$finalQuoteGuides['guideId'].'"'); 
									$guideData=mysqli_fetch_array($c);	 
			 
									?> 
									<tr>
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px" colspan="3" >
											<strong>Service&nbsp;Name</strong>
										</td> 
										<td bgcolor="#133f6d" style="color:#ffffff;font-size: 16px">
											<strong>Confirmation&nbsp;No.</strong>
										</td>
									</tr>
									<tr> 
										<td colspan="3" ><?php echo strip($guideData['name']); ?></td>  
										<td style="font-size:20px"><strong><em><?php echo strip($finalQuoteGuides['confirmationNo']); ?></em></strong></td>
									</tr>
									<?php 
								}
							}
						}
						
					
						?>  
						<!-- end of the services loop from final tables -->
					</table>
					<br />
					<br />


					<?php 
					if ($voucherDetailData['ArrivalDepartureStatus']==0) { ?>
					<!-- Arrival Departure for hotel and transfer-->
					<table width="100%" border="1" borderColor="#ccc" cellpadding="4" cellspacing="0">
						<tr>
							<td align="left" valign="middle" >
								<strong>Arrival On </strong>
							</td>
							<td align="left" valign="middle"  >
								<span style="width:94%;  padding:3px; "><?php if($voucherDetailData['h_arrival_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_arrival_on']!='0000-00-00' && $voucherDetailData['h_arrival_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_arrival_on'])); }else{ echo date("j M Y");} ?></span> 
							</td>
							<td align="left" valign="middle"  >
								<strong>From</strong>
							</td>
							<td align="left" valign="middle"  >
								<span style="width:94%;  padding:3px; "><?php echo strip($voucherDetailData['h_from']); ?></span>
							</td>
							<td align="left" valign="middle"  >
								<strong>By </strong>
							</td>
							<td align="left" valign="middle"  >
								<span style="width:94%;  padding:3px; "><?php echo strip($voucherDetailData['h_by_from']); ?></span> 
							</td>
							<td align="left" valign="middle"  >
								<strong>At </strong>
							</td>
							<td align="left" valign="middle"  >
								<span style="width:94%;  padding:3px; "><?php if($voucherDetailData['h_at_from']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_from'])); }else{ echo date("H:i");}   ?></span>
							</td>   
						</tr>
						<tr>
							<td align="left" valign="middle">
								<strong>Departure On </strong>
							</td>
							<td align="left" valign="middle">
								<span style="width:94%;  padding:3px; "><?php if($voucherDetailData['h_departure_on']!='1970-01-01 00:00:00' && $voucherDetailData['h_departure_on']!='0000-00-00' && $voucherDetailData['h_departure_on']!=''){ echo date('j M Y',strtotime($voucherDetailData['h_departure_on'])); }else{ echo date("j M Y");}   ?></span>
							</td>
							<td align="left" valign="middle">
								<strong>To </strong>
							</td>
							<td align="left" valign="middle">
								<span style="width:94%;  padding:3px; "><?php echo strip($voucherDetailData['h_to']); ?></span>
							</td>
							<td align="left" valign="middle">
								<strong>By </strong>
							</td>
							<td align="left" valign="middle">
								<span style="width:94%;  padding:3px; "><?php echo strip($voucherDetailData['h_by_to']); ?></span>
							</td>
							<td align="left" valign="middle">
								<strong>At </strong>
							</td>
							<td align="left" valign="middle">
								<span style="width:94%;  padding:3px; "><?php if($voucherDetailData['h_at_to']!=''){ echo date('H:i',strtotime($voucherDetailData['h_at_to'])); }else{ echo date("H:i");}   ?></span>
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
									<label><strong>Notes</strong><br>
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
										<strong>Billing Instructions</strong><br><?php 
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
			</div><br><?php 
			$cnt++;
		} 
	}
}
?>
</div> 
