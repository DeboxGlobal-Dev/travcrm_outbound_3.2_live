<?php include "inc.php";
$rsp1=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"');
$quotationData=mysqli_fetch_array($rsp1);

$noOfPax = $quotationData['adult']+$quotationData['child']+$quotationData['infant'];
$rsp=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'"');
$resultlists=mysqli_fetch_array($rsp);

$tourId  = makeQueryTourId($resultlists['id']);
$bookingId = makeQueryId($resultlists['id']);

$rs=GetPageRecord('*','newQuotationDays',' quotationId="'.$_REQUEST['quotationId'].'" and addstatus=0 order by srdate asc');
$resListing=mysqli_fetch_array($rs);

$rs2=GetPageRecord('*','newQuotationDays',' quotationId="'.$_REQUEST['quotationId'].'"  and addstatus=0  order by srdate desc');
$resListing2=mysqli_fetch_array($rs2);

$rs1=GetPageRecord('*',_SUPPLIERS_MASTER_,'id="'.$_REQUEST['supplierId'].'"');
$supplierDataa=mysqli_fetch_array($rs1);

$ders=GetPageRecord('*','suppliercontactPersonMaster',' corporateId='.$supplierDataa['id'].' and contactPerson!="" and deletestatus=0 order by id asc');
$supno=mysqli_fetch_array($ders);

$rsadd=GetPageRecord('*',_ADDRESS_MASTER_,' addressType="supplier" and addressParent='.$_REQUEST['supplierId'].' order by primaryAddress desc');
$resAddress=mysqli_fetch_array($rsadd);

if($resultlists['assignTo']!=''){  

	$rsu="";
	$rsu=GetPageRecord('*',_USER_MASTER_,' id="'.$resultlists['assignTo'].'"  '); 
	while($resListingu=mysqli_fetch_array($rsu)){  
		$assignTo = $resListingu['firstName'].' '.$resListingu['lastName']; 
		$emailsignature = $resListingu['emailsignature']; 
	}
}

$quotationId = $_REQUEST['quotationId']; 
$supplierId = $_REQUEST['supplierId'];
$dateSets = getHotelDateSets($quotationId,$supplierId);
$dateSetArray = explode('~',$dateSets); 
if(strlen($dateSets) > 0){ 
	foreach($dateSetArray as $dateSet){
	
	$srntag = strip($supplierData['id']."_".$cnt);
				
	$dateSetData = explode('^',$dateSet);
	$hotelId = $dateSetData[0];
	$fromDate = $dateSetData[1];
	$toDate = $dateSetData[2];
	$FID = $dateSetData[3];
	 
	$c="";
	$c=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelId.'"'); 
	$hotelData=mysqli_fetch_array($c); 
	 
	$hcity = strip($hotelData['hotelCity']);
	$hotcpm = GetPageRecord('*','hotelContactPersonMaster','corporateId="'.$hotelData['id'].'" and division=3');
	$hotelcpmData=mysqli_fetch_assoc($hotcpm);


	$g="";
	$g=GetPageRecord('*','finalQuote','id="'.$FID.'" '); 
	$finalQuotData=mysqli_fetch_array($g);
	$rrrrrr = $finalQuotData['specialRequest'];
	 
	
	$rooms = '';
	if($quotationData['sglRoom'] > 0){ $rooms .= $quotationData['sglRoom']." SGL,<br>"; }
	if($quotationData['dblRoom'] > 0){ $rooms .= $quotationData['dblRoom']." DBL,<br>"; }
	if($quotationData['tplRoom'] > 0){ $rooms .= $quotationData['tplRoom']." TPL,<br>"; }
	if($quotationData['twinRoom'] > 0){ $rooms .= $quotationData['twinRoom']." TWIN,<br>"; }
	if($quotationData['extraNoofBed'] > 0){ $rooms .= $quotationData['extraNoofBed']." EBed(A),<br>"; }
	if($quotationData['childwithNoofBed'] > 0){ $rooms .= $quotationData['childwithNoofBed']." CWBed,<br>"; }
	if($quotationData['childwithoutNoofBed'] > 0){ $rooms .= $quotationData['childwithoutNoofBed']." CNBed,<br>"; }
	if($quotationData['sixNoofBedRoom'] > 0){ $rooms .= $quotationData['sixNoofBedRoom']." SixBed,<br>"; }
	if($quotationData['eightNoofBedRoom'] > 0){ $rooms .= $quotationData['eightNoofBedRoom']." EightBed,<br>"; }
	if($quotationData['tenNoofBedRoom'] > 0){ $rooms .= $quotationData['tenNoofBedRoom']." TenBed,<br>"; }
	if($quotationData['quadNoofRoom'] > 0){ $rooms .= $quotationData['quadNoofRoom']." Quad,<br>"; }
	if($quotationData['teenNoofRoom'] > 0){ $rooms .= $quotationData['teenNoofRoom']." Teen,<br>"; }

	// SLAB AND ESCORT DETAILS
	$defaultSlabSql = "";
	$dividingFactor = 2;
	$defaultSlabSql = GetPageRecord('*', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1 ');
	if (mysqli_num_rows($defaultSlabSql)>0) {
	    $defaultSlabData = mysqli_fetch_array($defaultSlabSql);
	    $dividingFactor = $defaultSlabData['dividingFactor'];
	    $slabId = $defaultSlabData['id'];
	    $paxAdultLE = $defaultSlabData['localEscort'];
	    $paxAdultFE = $defaultSlabData['foreignEscort'];

	    $esQLE = ""; 
	    $esQLE = GetPageRecord('*', 'quotationFOCRates',' 1 and slabId="'.$slabId.'" and focType="LE" and quotationId="'.$quotationId.'"');
	    if (mysqli_num_rows($esQLE)>0 && $paxAdultLE>0) {
	        $escortDataLE = mysqli_fetch_array($esQLE);
	        if($escortDataLE['sglNORoom'] > 0){ $roomsLE .= $escortDataLE['sglNORoom']." SGL(LE) ,"; }
			if($escortDataLE['dblNORoom'] > 0){ $roomsLE .= $escortDataLE['dblNORoom']." DBL(LE) ,"; }
			if($escortDataLE['tplNORoom'] > 0){ $roomsLE .= $escortDataLE['tplNORoom']." TPL(LE) ,"; }
	    }
	    $esQFE = "";
	    $esQFE = GetPageRecord('*', 'quotationFOCRates', ' 1 and slabId="'.$slabId.'" and focType="FE" and quotationId="'.$quotationId.'"');
	    if (mysqli_num_rows($esQFE)>0 && $paxAdultFE>0) {
	        $escortDataFE = mysqli_fetch_array($esQFE);

        	if($escortDataFE['sglNORoom'] > 0){ $roomsFE .= $escortDataFE['sglNORoom']." SGL(FE) ,"; }
			if($escortDataFE['dblNORoom'] > 0){ $roomsFE .= $escortDataFE['dblNORoom']." DBL(FE) ,"; }
			if($escortDataFE['tplNORoom'] > 0){ $roomsFE .= $escortDataFE['tplNORoom']." TPL(FE) ,"; }

	    }

	}

	$CheckIn = date('d M Y',strtotime($fromDate));
	$CheckOut = date('d M Y',strtotime($toDate));
	$date1 = new DateTime($fromDate);
	$date2 = new DateTime($toDate);
	$interval = $date1->diff($date2);
	$nights = $interval->days;  
?>

<br>
<br>
<br>
<div style="margin-right:auto; width:700px; font-size:10px; border:1px solid #ccc; padding:5px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size:11px;">
		<tr>
			<td align="center"><img src="download/<?php echo $masterProposalLogo; ?>" alt="<?php echo $clientnameglobal; ?>" width="640" height="100"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<!-- hotel reservation request -->
		<tr>
			<td align="center"><strong>Hotel Reservation Request</strong></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="2" >

            <tr>

                <td width="50%">

                         <table width="100%" border="0" cellspacing="0" cellpadding="2">

                             <tr>

                                 <td><strong>To:&nbsp;</strong><a href=""><strong><?php echo $supplierDataa['name']; ?></strong></a></td>

                                 

                             </tr>

                             <tr><td><strong>Address&nbsp;:&nbsp;</strong><?php echo $resAddress['address']; ?></td></tr>

                             <tr> <td><strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo $supno['contactPerson']; ?></td></tr>

                             <tr><td><strong>Phone&nbsp;:&nbsp;</strong><?php echo decode($supno['phone']); ?></td></tr>

                             <tr><td><strong>Email&nbsp;:&nbsp;</strong><?php echo decode($supno['email']); ?></td></tr>

                             

                         </table>

                </td>

                <td width="50%">
                	
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">

						<tr>

							<td  align="left"><strong>Tour No&nbsp;:&nbsp;</strong><?php echo makeQueryTourId($resultlists['id']); ?></td>

						</tr>
						<tr>
							<td  align="left"><strong>Booking No&nbsp;:&nbsp;</strong><?php echo makeQueryId($resultlists['id']); ?></td>
						</tr>

						<tr><td align="left"><strong>Date&nbsp;:&nbsp;</strong><?php echo date('d-m-Y',strtotime($quotationData['fromDate'])); ?></td></tr>

					<tr><td  align="left"><strong>Lead &nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</strong><?php echo $resultlists['leadPaxName']; ?></td></tr>

						<tr><td align="left"><strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $noOfPax; ?></td></tr>

                             

                         </table>
                </td>


            </tr>

             

           

        </table></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>The Reservation Manager,<br /><br />
			<!-- <br /><br />
			REFERENCE: <?php echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); ?> / <?php echo $tourId; ?><br /><br /> -->
			Dear Sir / Madam,<br /><br /> 
			Please book and confirm accommodation for the above mentioned client/s as per details below :<br /></td>
		</tr> 

		<tr> 
			<td>
			<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:11px;">
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
							?> 
							<!-- <i style="font-size: 16px;vertical-align:bottom; color:<?php if($starcolor['proposalColor']!=''){ echo $starcolor['proposalColor']; }else{ echo '#dcff2e'; } ?>;" class="fa fa-star" aria-hidden="true"></i> -->
							<img style="vertical-align: bottom;" src="download/hotelStar.png" alt="Hotel Star" width="18" height="18">
							
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
				<tr>
					<td colspan="2" align="center"><strong>Date(s)</strong></td>
					<td width="12%" rowspan="2" align="center" valign="top"><strong>Place</strong></td>
					<td width="20%" rowspan="2" align="center" valign="top"><strong>Hotel</strong></td>
					<td width="12%" rowspan="2" align="center" valign="top"><strong>Unit</strong></td>
					<td colspan="2" align="center"><strong>Status Details</strong></td>
				</tr>
				<tr>
					<td width="25%"><strong>Date</strong></td>
					<td width="5%"><strong>Nights</strong></td>
					<td width="10%"><strong>Status</strong></td>
					<td width="18%"><strong>Reference</strong></td>
				</tr>  
				<?php   

				$g2="";
				$g2=GetPageRecord('*, count(*) as num, min(fromDate) as fromDate, max(toDate) as toDate','finalQuote',' quotationId="'.$quotationId.'" and hotelId="'.$hotelId.'" and supplierId="'.$supplierId.'" and fromDate between "'.$fromDate.'" and "'.$toDate.'" group by roomType,mealPlanId order by fromDate asc'); 
				if(mysqli_num_rows($g2)>0){ 
					$cntH = 1;
					while($finalQuoteHotelData=mysqli_fetch_array($g2)){ 

							$totalRoom = $finalQuoteHotelData['roomSingle']+$finalQuoteHotelData['roomDouble']+$finalQuoteHotelData['roomTriple']+$finalQuoteHotelData['roomTwin'];
							


							$f="";
							$f=GetPageRecord('*','finalQuotSupplierStatus','supplierId="'.$finalQuoteHotelData['supplierId'].'" and quotationId="'.$quotationId.'"  '); 
							$finalQuoteSuppStatusData=mysqli_fetch_array($f);
							$isCostShow=$finalQuoteSuppStatusData['isCostShow'];
							$supplierId=$finalQuoteSuppStatusData['supplierId'];
								
							$g="";
							$g=GetPageRecord('*',_ROOM_TYPE_MASTER_,'id="'.$finalQuoteHotelData['roomType'].'"'); 
							$roomTypeData=mysqli_fetch_array($g);
							$rType=$roomTypeData['name'];
								
							
							$g="";
							$g=GetPageRecord('*',_MEAL_PLAN_MASTER_,'id="'.$finalQuoteHotelData['mealPlanId'].'"'); 
							$mealData=mysqli_fetch_array($g); 
							$mealplan = $mealData['name'];
							//.'-'.$mealData['subname']
							if($cntH == 1){
							if($finalQuoteHotelData['isLocalEscort'] == 1){
								$rooms .= $roomsLE;
							}
							if($finalQuoteHotelData['isForeignEscort'] == 1){
								$rooms .= $roomsFE;
							}
							?>
							<tr>
								<td><?php echo $CheckIn; ?>- <?php echo $CheckOut; ?></td>
								<td><?php echo $nights; ?></td>
								<td><?php echo $hcity; ?></td>
								<td><?php echo strip($hotelData['hotelName']);  ?></td>
								<td><?php echo rtrim($rooms,' ,'); ?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<?php
						}
						?>
						<tr> 
							<td colspan="7"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
							<tr>
								<td width="45%"><b>CheckIn&nbsp;:&nbsp;</b><?php echo date('d M Y',strtotime($finalQuoteHotelData['fromDate']))."&nbsp;,&nbsp;<b>CheckOut&nbsp;:&nbsp;</b>".date('d M Y',strtotime($finalQuoteHotelData['toDate'])+86400); ?></td>  
								<td width="30%"><b>Room Type&nbsp;:</b>&nbsp;
									<?php echo $rType.' ('.$totalRoom.')'; ?>
								</td> 
								<td><b>Meal&nbsp;Plan&nbsp;:</b>&nbsp;<?php echo $mealplan; ?>
							
								<!-- mael plane code started  -->
								<?php 
									$where22r='quotationId="'.$quotationId.'" and isHotelSupplement!=1  and isRoomSupplement!=1 and supplierMasterId="'.$supplierId.'" order by fromDate asc';   
									$rs2233=GetPageRecord('*','quotationHotelMaster',$where22r);  
									if(mysqli_num_rows($rs2233) > 0){
									
										 
										 $hotellisting=mysqli_fetch_array($rs2233);


										 if($hotellisting['complimentaryBreakfast']>0){
											$breakfast = ", Breakfast";
										}else{
											$breakfast = '';
										}
					
										if($hotellisting['complimentaryLunch']>0){
											$lunch = ", Lunch";
										}else{
											$lunch = '';
										}
										
										if($hotellisting['complimentaryDinner']>0){
											$dinner = ", Dinner";
										}else{
											$dinner = '';
										}
										if($editresult2['subname']!=''){
											echo " ".clean($editresult2['subname'].' '.$breakfast.'  '.$lunch.' '.$dinner);
										}else{
											echo " ".clean($editresult2['name'].' '.$breakfast.' '.$lunch.' '.$dinner);
										}
										


									}
									
									?>
									
							
								<!-- meal plane code ended -->
							</td>

							</tr>
							</table></td>
						</tr> 
						<?php if($isCostShow == 1){ ?>
						<tr> 
							<td>Costing&nbsp;Details&nbsp;:<br><span style="font-size:9px">(Per Room)</span></td>
							<td colspan="2"><?php  
								if($finalQuoteHotelData['roomSingle']>0 && $finalQuoteHotelData['roomSingleCost']>0){
									echo '<b>Single&nbsp;Basis</b>&nbsp;-&nbsp;'.round($finalQuoteHotelData['roomSingleCost']).'<br>';
								}
								if($finalQuoteHotelData['roomDouble']>0 && $finalQuoteHotelData['roomDoubleCost']>0){
									echo '<b>Double&nbsp;Basis</b>&nbsp;-&nbsp;'.round($finalQuoteHotelData['roomDoubleCost']).'<br>';
								}
								if($finalQuoteHotelData['roomTwin']>0 && $finalQuoteHotelData['roomTwinCost']>0){
									echo '<b>Twin&nbsp;Basis</b>&nbsp;-&nbsp;'.round($finalQuoteHotelData['roomTwinCost']).'<br>';
								}
								if($finalQuoteHotelData['roomTriple']>0 && $finalQuoteHotelData['roomTripleCost']>0){
									echo '<b>Triple&nbsp;Basis</b>&nbsp;-&nbsp;'.round($finalQuoteHotelData['roomTripleCost']).'<br>';
								}
							?></td>
							<td colspan="2"><?php 
								
								if($finalQuoteHotelData['quadNoofRoom']>0 && $finalQuoteHotelData['quadRoomCost']>0){
									echo '<b>Quad Room Basis</b> - '.round($finalQuoteHotelData['quadRoomCost']).'<br>';
								}
								if($finalQuoteHotelData['sixNoofBedRoom']>0 && $finalQuoteHotelData['sixBedRoomCost']>0){
									echo '<b>Six BedRoom Basis</b> - '.round($finalQuoteHotelData['sixBedRoomCost']).'<br>';
								}
								if($finalQuoteHotelData['eightNoofBedRoom']>0 && $finalQuoteHotelData['eightBedRoomCost']>0){
									echo '<b>Eight BedRoom Basis</b> - '.round($finalQuoteHotelData['eightBedRoomCost']).'<br>';
								}
								if($finalQuoteHotelData['tenNoofBedRoom']>0 && $finalQuoteHotelData['tenBedRoomCost']>0){
									echo '<b>Ten BedRoom Basis</b> - '.round($finalQuoteHotelData['tenBedRoomCost']).'<br>';
								}
							?></td>
							<td colspan="2"><?php 
								if($finalQuoteHotelData['roomEBedA']>0 && $finalQuoteHotelData['roomEBedACost']>0){
									echo '<b>Extra Bed Adult</b> - '.round($finalQuoteHotelData['roomEBedACost']).'<br>';
								}
								if($finalQuoteHotelData['roomEBedC']>0 && $finalQuoteHotelData['roomEBedCCost']>0){
									echo '<b>Extra Bed Child</b> - '.round($finalQuoteHotelData['roomEBedCCost']).'<br>';
								}
								if($finalQuoteHotelData['roomENBedC']>0 && $finalQuoteHotelData['roomENBedCCost']>0){
									echo '<b>No Bed Child</b> - '.round($finalQuoteHotelData['roomENBedCCost']).'<br>';
								}
							?></td>
						</tr>
							<?php
							}
							$cntH++;
						}

						$rs12='';
						$rs12=GetPageRecord('*','quotationHotelAdditionalMaster','hotelQuotId="'.$finalQuotData['hotelQuotationId'].'" and quotationId="'.$finalQuotData['quotationId'].'" '); 
						while ($editresult2=mysqli_fetch_array($rs12)) {
							$rtype  .= $editresult2['name'].', ';
						}
						?>
								<tr> 
									<td colspan="7"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px;">
									<tr>
										<td width="20%"><b>Hotel Additionals</b></td>  
										<td width="80%"><?php echo rtrim($rtype,', '); ?></td> 
									</tr>
									<tr>
										<td width="20%"><b>Remarks</b></td>  
										<td width="80%"><?php echo $rrrrrr; ?></td> 
									</tr>

									<tr>
										<td width="20%"><b>Billing Instructions</b></td>  
										<td width="80%"><?php echo ''; ?></td> 
									</tr>

									</table></td>
								</tr> 
					<?php
				}
				?>
			</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Your  confirmation for the above requested accommodation on this mail shall be highly appreciated.<br /><br />
				Thanking you<br /><br />
				With warm regards,<br /><br />
				<?php  
            	if(preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', stripslashes($emailsignature), $emailsignatureSRC)){
            	    echo '<img src='.array_pop($emailsignatureSRC).' width="100%" height="auto" alt="signature" style="max-width:700px;"/>';
            	}
				//echo $emailsignature; ?>
				<br />
				<br />
				You are requested to inform us immediately of any renovation and/or disruption of any service like closure of swimming-pool, restaurant, renovation impediments/hindrances in public areas, noise, etc. planned at your hotel during the stay of our above client, to minimize complaints and compensations to clients.<br /><br />
			This is a computer generated request and does not require a signature.</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<!-- <tr>
			<td align="center"><a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666; font-size:9px;">Genrated by TravCRM</a></td>
		</tr> -->
	</table>
</div>
<?php

}
}

$b="";$b=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$_REQUEST['quotationId'].'" and supplierId = "'.$_REQUEST['supplierId'].'"');
$c="";$c=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$nm="";$nm=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$d="";$d=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$e="";$e=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$f="";$f=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$g="";$g=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$ad="";$ad=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$en="";$en=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$mp="";$mp=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$mv="";$mv=GetPageRecord('*','finalQuoteVisa',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$fp="";$fp=GetPageRecord('*','finalQuotePassport',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');
$fi="";$fi=GetPageRecord('*','finalQuoteInsurance',' quotationId="'.$_REQUEST['quotationId'].'"  and supplierId = "'.$_REQUEST['supplierId'].'"');

if(mysqli_num_rows($b)>0 || mysqli_num_rows($c)>0 || mysqli_num_rows($nm)>0 || mysqli_num_rows($d)>0 || mysqli_num_rows($e)>0 || mysqli_num_rows($f)>0 || mysqli_num_rows($g)>0 || mysqli_num_rows($ad)>0 || mysqli_num_rows($en)>0 || mysqli_num_rows($mp)>0 || mysqli_num_rows($fi)>0 || mysqli_num_rows($fp)>0 || mysqli_num_rows($mv)>0){
?>
<br>
<br>
<br>
<div style="margin-right:auto; width:700px; font-size:10px; border:1px solid #ccc; padding:5px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size:11px;">
		<tr>
			<td align="center"><img src="download/<?php echo $masterProposalLogo; ?>" alt="<?php echo $clientnameglobal; ?>" width="640" height="100"></td>
		</tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="2" >

            <tr>

                <td width="50%">


                	

                         <table width="100%" border="0" cellspacing="0" cellpadding="2">

                             <tr>

                                 <td><strong>To:&nbsp;</strong><a href=""><strong><?php  echo $supplierDataa['name']; ?></strong></a></td>

                                 

                             </tr>

                             <tr><td><strong>Address&nbsp;:&nbsp;</strong><?php echo $resAddress['address']; ?></td></tr>

                             <tr> <td><strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo $supno['contactPerson']; ?></td></tr>

                             <tr><td><strong>Phone&nbsp;:&nbsp;</strong><?php echo decode($supno['phone']); ?></td></tr>

                             <tr><td><strong>Email&nbsp;:&nbsp;</strong><?php echo decode($supno['email']); ?></td></tr>


                         </table>

                </td>

                <td width="50%">
                	
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                             <tr>
                                 <td  align="left"><strong>Tour No&nbsp;:&nbsp;</strong><?php echo makeQueryTourId($resultlists['id']); ?></td>
                             </tr>
                             <tr>

                                 <td  align="left"><strong>Booking No&nbsp;:&nbsp;</strong><?php echo makeQueryId($resultlists['id']); ?></td>
                             </tr>

                             <tr><td align="left"><strong>Date&nbsp;:&nbsp;</strong><?php echo date('d-m-Y',strtotime($quotationData['fromDate'])); ?></td></tr>

                            <tr><td  align="left"><strong>GSTIN &nbsp;:&nbsp;</strong><?php echo $resAddress['gstn']; ?></td></tr>

                             <tr><td align="left"><strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $noOfPax; ?></td></tr>

                             

                         </table>
                </td>


            </tr>

             

           

        </table></td>
		</tr>
		
		   <tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><strong><u>Favouring <?php echo $resultlists['subject']; ?></u></strong></td>
			</tr>

			<tr>
				<td><strong >Lead&nbsp;Pax&nbsp;Name:&nbsp;</strong><?php echo $resultlists['leadPaxName']; ?></td>
			</tr>
			
			<tr>
				<td>Please provide all services as  per below details.</td>
			</tr>

			<tr>
				<td>
				<?php
				
				$rsp=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.($_REQUEST['quotationId']).'"');
				$quotationData=mysqli_fetch_array($rsp);
				
				$suppQuery="";
				$suppQuery = ' id = "'.$_REQUEST['supplierId'].'"';
				$suppSql=GetPageRecord('*','suppliersMaster',$suppQuery);
				while($supplierData=mysqli_fetch_array($suppSql)){
							
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
							$rsh=GetPageRecord('*',_QUOTATION_TRANSFER_MASTER_,' id = "'.$finalQuotTransfer['transferQuotationId'].'"');
							$transferQuotData=mysqli_fetch_array($rsh);

							$select2='carType,model';  
					        $where2='id="'.$transferQuotData['vehicleModelId'].'"'; 
					        $rs2=GetPageRecord($select2,_VEHICLE_MASTER_MASTER_,$where2); 
					        $editresult2=mysqli_fetch_array($rs2);
							
							$Ecity = getDestination($transferQuotData['destinationId']);
							
							$transferDates = date('d M, Y',strtotime($transferQuotData['fromDate']));
							
							$d="";
							$d=GetPageRecord('*','vehicleMaster','id="'.$transferQuotData['vehicleId'].'"');
							$vehicleData=mysqli_fetch_array($d);
							$e="";
							$e=GetPageRecord('*','vehicleBrand','id="'.$vehicleData['brand'].'"');
							$vehicleBrandData=mysqli_fetch_array($e);
							
							if($finalQuotTransfer['transferType']==1){
								$transferType = " SIC | ";
							}else{
								$transferType = " PVT | ";
							}
							// $c1="";
							// $c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferQuotData['id'].'" and quotationId="'.$quotationData['id'].'"');
							// $TMData=mysqli_fetch_array($c1);
							// echo $transferQuotData['id'];
				
		$c1=GetPageRecord('*','quotationTransferTimelineDetails',' transferQuoteId="'.$transferQuotData['id'].'" and quotationId="'.$quotationData['id'].'"');
		if(mysqli_num_rows($c1)>0){
		$transferTimelineData=mysqli_fetch_array($c1);
		
		if($transferTimelineData['arrivalTime']!='' && $transferTimelineData['arrivalTime']!='00:00:00'){
			$arrivalTime = date('H:i',strtotime($transferTimelineData['arrivalTime']));
		}else{
			$arrivalTime = '';
		}

		if($transferTimelineData['pickupTime']!='' && $transferTimelineData['pickupTime']!='00:00:00'){
			$pickupTime = date('H:i',strtotime($transferTimelineData['pickupTime']));
		}else{
			$pickupTime = '';
		}

		if($transferTimelineData['dropTime']!='' && $transferTimelineData['dropTime']!='00:00:00'){
			$dropTime = date('H:i',strtotime($transferTimelineData['dropTime']));
		}else{
			$dropTime = '';
		}

		if($transferTimelineData['mode']=='flight'){
			$transfername = $transferTimelineData['flightName'];
		}elseif($transferTimelineData['mode']=='train'){
			$transfername = $transferTimelineData['trainName'];
		}

		if($transferTimelineData['mode']=='flight'){
			$transferNumber = $transferTimelineData['flightNumber'];
		}elseif($transferTimelineData['mode']=='train'){
			$transferNumber = $transferTimelineData['trainNumber'];
		}
	

	}
	?>

		<table  width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF" class="tablesorter gridtable">
		<tr>
			<th colspan="9" align="left"><?php echo $transferType.$transferData['transferName']; ?>&nbsp; <strong><?php if($finalQuotTransfer['transferType']==2){ ?> | Vehicle Type:&nbsp;</strong><?php echo getVehicleTypeName($transferQuotData['vehicleType']); }?></th> 
			</tr>
			<tr>
			<th colspan="9" align="left"><?php echo "Arrival From ".$transferTimelineData['arrivalFrom']." by ".ucwords($transferTimelineData['mode'])." ".$transferDates; ?></th> 
			</tr>
			
		<tr style="background:#ddd;">
						<th align="left">Mode</th>
						<?php if($transferTimelineData['mode']=='Local'){ ?>
						<th align="left">Date</th>
						<?php } if($transferTimelineData['mode']=='flight' || $transferTimelineData['mode']=='train'){ ?>
						<th align="left">Arrival&nbsp;From</th>
						<th align="left">Arrival&nbsp;Time</th>

						<th align="left">
							<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Name'; }else{ echo 'Train&nbsp;Name'; } ?>
						</th>
				
						<th align="left">
							<?php if($transferTimelineData['mode']=='flight'){ echo 'Flight&nbsp;Number'; }else{ echo 'Train&nbsp;Number'; } ?>
						</th>
					<?php } ?>

					<?php if($transferTimelineData['mode']=='flight'){ ?> 
						<th align="left">Airport&nbsp;Name</th>
					<?php } ?>

						<th align="left">Pickup&nbsp;Time</th>
						<th align="left">Drop&nbsp;Time</th>
						<th align="left">pickup&nbsp;Address</th>
						<th align="left">Drop&nbsp;Address</th>
					</tr>
					<tr>
						<td><?php echo ucfirst($transferTimelineData['mode']); ?></td>
						<?php if($transferTimelineData['mode']=='Local'){ ?>
						<td><?php echo date('d-m-Y',strtotime($transferTimelineData['departureDate'])); ?></td>

					<?php } if($transferTimelineData['mode']=='flight' || $transferTimelineData['mode']=='train'){ ?> 
						<td><?php echo $transferTimelineData['arrivalFrom']; ?></td>
						<td><?php echo $arrivalTime; ?></td>
						
						<td><?php echo $transfername; ?></td>
						<td><?php echo $transferNumber; ?></td>
						<?php } ?>	
						<?php if($transferTimelineData['mode']=='flight'){ ?> 
						<td align="left">
							<?php echo $transferTimelineData['airportName']; ?>
						</td>
					<?php } ?>

						<td><?php echo $pickupTime; ?></td>
						<td><?php echo $dropTime; ?></td>
						<td><?php echo $transferTimelineData['pickupAddress']; ?></td>
						<td><?php echo $transferTimelineData['dropAddress']; ?></td>
					</tr>
					<tr><td>Remarks : <?php echo $finalQuotTransfer['specialRequest']; ?></td></tr>
		</table>
	

							<br />
							<?php
						}
					}	

					$eee="";
					$eee=GetPageRecord('*','finalQuoteFerry',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($eee) > 0){
						while($finalQuoteFerryData=mysqli_fetch_array($eee)){
						
						
						$ddd="";
						$ddd=GetPageRecord('*',_FERRY_SERVICE_PRICE_MASTER_,'id="'.$finalQuoteFerryData['ferryId'].'"'); 
						$ferryQuotData=mysqli_fetch_array($ddd);
						
						$supplierId = $finalQuoteFerryData['supplierId'];
						$ferryname = $ferryQuotData['name'];

						
						$ferryDates = date('d M,Y',strtotime($TimeData['fromDate']));
						// $Ecity = strip($entranceData['entranceCity']);

						$ccc1="";
						$ccc1=GetPageRecord('*','quotationFerryMaster','  id="'.$finalQuoteFerryData['ferryQuotationId'].'"'); 
						$TimeData=mysqli_fetch_array($ccc1);
						$FerryDate1 = $TimeData['fromDate'];

						$dddd="";
						$dddd=GetPageRecord('*','ferryClassMaster','  id="'.$TimeData['ferryClass'].'"'); 
						$ferryClassname=mysqli_fetch_array($dddd);
							
						?>
						
						<table width="100%" border="1" cellspacing="0" cellpadding="3">

						<tr>
							<td bgcolor="#F3F3F3" style="width: 13%;">
								<strong>Date</strong>
							</td>
							<td bgcolor="#F3F3F3" >
								<strong>Ferry&nbsp;Name</strong>
							</td>

							<td bgcolor="#F3F3F3" width="35%">
								<strong>Seat&nbsp;Type </strong>
							</td>
							<td bgcolor="#F3F3F3">
								<strong>Arrival&nbsp;Time</strong>
							</td>
							<td bgcolor="#F3F3F3">
								<strong>Departure&nbsp;Time</strong>
							</td>
							<td bgcolor="#F3F3F3">
								<strong>Confirmation&nbsp;No.</strong>
							</td>
						</tr>
							<tr> 
							<td>
							<!-- date('d M,Y',strtotime($TimeData['fromDate'])) -->
								<?php echo date('d M Y',strtotime($FerryDate1)); ?>
							</td>
							<td>Ferry : <?php echo strip($ferryQuotData['name']); ?></td> 
							<td><?php echo strip($ferryClassname['name']); ?></td> 
							<td><?php echo $TimeData['pickupTime']; ?></td> 
							<td><?php echo $TimeData['dropTime']; ?></td> 
							<td style="font-size:16px"><strong><em> <?php echo strip($finalQuoteFerryData['confirmationNo']); ?></em></strong></td>
							</tr>
							<tr>
								<td>Remarks</td>
								<td><?php echo $finalQuoteFerryData['specialRequest'];?></td>
							</tr>
						</table><br />
							<?php
						}
					}
					
					$b="";
					$b=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
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
							
								$entranceDates = date('d M,Y',strtotime($entranceQuotData['fromDate']));
								$Ecity = strip($entranceData['entranceCity']);
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $entranceDates; ?></td>
									<td width="3%" align="center">:</td>
									<td colspan="6"><?php echo strip($entranceData['entranceName']);  ?></td>
								</tr>


								<tr>
									<td width="15%">Remarks </td>
									<td width="3%" align="center">:</td>
									<td colspan="6"><?php echo strip($finalQuoteEntranceData['specialRequest']);  ?></td>
								</tr>
								<?php
						$c="";
						$c=GetPageRecord('*','quotationEntranceTimelineDetails',' hotelQuoteId="'.$entranceQuotData['id'].'" and quotationId="'.$entranceQuotData['quotationId'].'"');
						if(mysqli_num_rows($c)>0){
							$entranceTimLData=mysqli_fetch_array($c);
							if($entranceTimLData['startTime']!='' && $entranceTimLData['startTime']!='00:00:00'){
								$startTime = date('H:i:s', strtotime($entranceTimLData['startTime']));
							}else{
								$startTime = '';
							}
						
							if($entranceTimLData['endTime']!='' && $entranceTimLData['endTime']!='00:00:00'){
								$endTime = date('H:i:s', strtotime($entranceTimLData['endTime']));
							}else{
								$endTime = '';
							}

							if($entranceTimLData['pickupTime']!='' && $entranceTimLData['pickupTime']!='00:00:00'){
								$pickupTime = date('H:i:s', strtotime($entranceTimLData['pickupTime']));
							}else{
								$pickupTime = '';
							}

							if($entranceTimLData['dropTime']!='' && $entranceTimLData['dropTime']!='00:00:00'){
								$dropTime = date('H:i:s', strtotime($entranceTimLData['dropTime']));
							}else{
								$dropTime = '';
							}


							
						
						?>
					
					<tr style="background:#ddd;">
						<th align="left">Date</th>
						<th align="left">Start&nbsp;Time</th>
						<th align="left">End&nbsp;Time</th>
						<th align="left">Pickup&nbsp;Time</th>
						<th align="left">Drop&nbsp;Time</th>
						<th align="left" colspan="2">pickup&nbsp;Address</th>
						<th align="left"  colspan="2">Drop&nbsp;Address</th>
					</tr>
					<tr>
						
						<td><?php echo date('d-m-Y',strtotime($entranceTimLData['endTime'])); ?></td>
						<td><?php echo $startTime; ?></td>
						<td><?php echo $endTime; ?></td>
						<td><?php echo $pickupTime; ?></td>
						<td><?php echo $dropTime; ?></td>
						<td colspan="2"><?php echo $entranceTimLData['pickupAddress']; ?></td>
						<td colspan="2"><?php echo $entranceTimLData['dropAddress']; ?></td>
					</tr>
					<?php } ?>
							</table><br />
							<?php
						}
					}
					
					$b="";
					$b=GetPageRecord('*','finalQuoteActivity',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($b) > 0){
					
						while($finalQuoteActivityData=mysqli_fetch_array($b)){
							
							$d="";
							$d=GetPageRecord('*','packageBuilderotherActivityMaster',' id="'.$finalQuoteActivityData['activityId'].'"');
							$activityData=mysqli_fetch_array($d);
							$activityId = $activityData['id'];
							
							$rsh="";
							$rsh=GetPageRecord('*',_QUOTATION_OTHER_ACTIVITY_MASTER_,' id="'.$finalQuoteActivityData['activityQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');
							$activityQuotData=mysqli_fetch_array($rsh);
							
							$activityDates = date('d M,Y',strtotime($activityQuotData['fromDate']));
							$Ecity = strip($activityData['otherActivityCity']);
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $activityDates;  ?></td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($activityData['otherActivityName']);  ?></td>
								</tr>
								<tr>
									<td>Remarks</td>
									<td width="3%" align="center">:</td>
									<td><?php echo $finalQuoteActivityData['specialRequest']?></td>
								</tr>
								
							</table><br />
							<?php
						}
					}
					
					$b="";
					$b=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($b) > 0){
						while($finalQuoteTrainData=mysqli_fetch_array($b)){
							$d="";
							$d=GetPageRecord('*',_PACKAGE_BUILDER_TRAINS_MASTER_,' id="'.$finalQuoteTrainData['trainId'].'"');
							$trainData=mysqli_fetch_array($d);
							$trainId = $trainData['id'];
							$rsh="";
							$rsh=GetPageRecord('*',_QUOTATION_TRAINS_MASTER_,' id="'.$finalQuoteTrainData['trainQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');
							$trainQuotData=mysqli_fetch_array($rsh);
							$trainDates = date('d M,Y',strtotime($trainQuotData['fromDate']));
							$Ecity = getDestination($trainQuotData['destinationId']);
							?>
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $trainDates;  ?></td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($trainData['trainName']);  ?></td>
								</tr>
								<tr>
									<td width="15%">Remarks</td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($finalQuoteTrainData['specialRequest']);  ?></td>
								</tr>
							</table><br />
							<?php 
								$rsst = GetPageRecord('*','trainMultiDetailMaster','quotationId="'.$finalQuoteTrainData['quotationId'].'" and parentId="'.$finalQuoteTrainData['id'].'"');
								if(mysqli_num_rows($rsst)>0){
									?>
								<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<th align="left">Name</th>
									<th align="left">Gender</th>
									<th align="left">PNR&nbsp;No</th>
									<th align="left">Confirmation No.</th>
								</tr>
								
								<?php
								
								while($flightmultDatat = mysqli_fetch_assoc($rsst)){
									?>
									<tr>
								
										<td><?php echo $flightmultDatat['title'].' '. $flightmultDatat['firstName'].' '. $flightmultDatat['middleName'].' '. $flightmultDatat['lastName'] ?></td>
										<td><?php echo $flightmultDatat['gender']; ?></td>
										<td><?php echo $flightmultDatat['pnrNo']; ?></td>
										<td><?php echo $flightmultDatat['confirmationNo']; ?></td>
									
									</tr>
									
									<?php
								}
							
								?>
							
							</table><br />
							<?php
								}
							
						}
					}
					
					$b="";
					$b=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($b) > 0){
						while($finalQuoteFlightData=mysqli_fetch_array($b)){
							$d="";
							$d=GetPageRecord('*',_PACKAGE_BUILDER_FLIGHT_MASTER_,' id="'.$finalQuoteFlightData['flightId'].'"');
							$flightData=mysqli_fetch_array($d);
							$flightId = $flightData['id'];
							
							$rsh="";
							$rsh=GetPageRecord('*',_QUOTATION_FLIGHT_MASTER_,' id="'.$finalQuoteFlightData['flightQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');
							$flightQuotData=mysqli_fetch_array($rsh);
							
							$flightDates = date('d M,Y',strtotime($flightQuotData['fromDate']));
							$Ecity = getDestination($flightQuotData['destinationId']);
							?>
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $flightDates;  ?></td>
									<td width="3%" align="center">:</td>
									<td width="82%" colspan="4"><?php echo strip($flightData['flightName']);  ?></td>
								</tr>
								</table>
								<?php 
								$rss = GetPageRecord('*','flightMultiDetailMaster','quotationId="'.$finalQuoteFlightData['quotationId'].'" and parentId="'.$finalQuoteFlightData['id'].'"');
								if(mysqli_num_rows($rss)>0){
									?>
								<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<th align="left">Name</th>
									<th align="left">Gender</th>
									<th align="left">PNR&nbsp;No</th>
									<th align="left">Ticket&nbsp;No.</th>
								</tr>
								
								<?php
								
								while($flightmultData = mysqli_fetch_assoc($rss)){
									?>
									<tr>
								
										<td><?php echo $flightmultData['title'].' '. $flightmultData['firstName'].' '. $flightmultData['middleName'].' '. $flightmultData['lastName'] ?></td>
										<td><?php echo $flightmultData['gender']; ?></td>
										<td><?php echo $flightmultData['pnrNo']; ?></td>
										<td><?php echo $flightmultData['confirmationNo']; ?></td>
									
									</tr>
									<?php
								}
							
								?>
							
							</table><br />
							<?php
								}
						}
					}
					
					$b="";
					$b=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($b) > 0){
						while($finalQuoteGuideData=mysqli_fetch_array($b)){
							$d="";
							$d=GetPageRecord('*',_GUIDE_SUB_CAT_MASTER_,' id="'.$finalQuoteGuideData['guideId'].'"');
							$guideData=mysqli_fetch_array($d);
							$guideId = $guideData['id'];
							$rsh="";
							$rsh=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,' id="'.$finalQuoteGuideData['guideQuotationId'].'" and quotationId="'.$quotationData['id'].'" order by id desc limit 1');
							$guideQuotData=mysqli_fetch_array($rsh);

							$where11= 'id="'.$guideQuotData['tariffId'].'"'; 
						    $rs11 = GetPageRecord('*','dmcGuidePorterRate',$where11); 
						    $dmcroommastermaina = mysqli_fetch_array($rs11); 
							
								$guideDates = date('d M, Y',strtotime($guideQuotData['fromDate']));
							$Ecity = getDestination($guideQuotData['destinationId']);

							if(trim($dmcroommastermaina['dayType']) == 'fullday'){
							  $dayType = "Full Day";
						     }else{
							$dayType = "Half Day";
						    }
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $guideDates;  ?></td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($guideData['name']).', '.$dayType;  ?></td>
								</tr>

								<tr>
									<td width="15%">Remarks </td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($finalQuoteGuideData['specialRequest']).', '.$dayType;  ?></td>
								</tr>

							</table><br />
							<?php
						}
					}

					$adv="";
					$adv=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($adv) > 0){
						while($finalQuoteAdditionalData=mysqli_fetch_array($adv)){

							$sdq=GetPageRecord('*',_QUOTATION_EXTRA_MASTER_,' id="'.$finalQuoteAdditionalData['additionalQuotationId'].'" order by id desc');   
                            $additionalQuotData=mysqli_fetch_array($sdq);

							
								$additionaDates = date('d M, Y',strtotime($finalQuoteAdditionalData['fromDate']));
							$Ecity = getDestination($finalQuoteAdditionalData['destinationId']);
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $additionaDates;  ?></td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($additionalQuotData['name']);  ?></td>
								</tr>
								<tr>
									<td width="15%">Remarks</td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo $finalQuoteAdditionalData['specialRequest'];  ?></td>
								</tr>
							</table><br />
							<?php
						}
					}


					$enr="";
					$enr=GetPageRecord('*','finalQuoteEnroute',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($enr) > 0){
						while($finalQuoteEnroutData=mysqli_fetch_array($enr)){
                            
							$sdq=GetPageRecord('*',_PACKAGE_BUILDER_ENROUTE_MASTER_,' id="'.$finalQuoteEnroutData['enrouteId'].'" order by id desc');   
                            $enroutQuotData=mysqli_fetch_array($sdq);

                            

							
								$enroutDates = date('d M, Y',strtotime($finalQuoteEnroutData['fromDate']));
							$Ecity = getDestination($finalQuoteEnroutData['destinationId']);
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $enroutDates;  ?></td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($enroutQuotData['enrouteName']);  ?></td>
								</tr>
							</table>
							<br />
							<?php
						}
					}

					$mp=""; 
					$mp=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($mp) > 0){
						while($finalQuoteMealPlanData=mysqli_fetch_array($mp)){
                            
							$rsh="";
							$rsh=GetPageRecord('*',_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,' id = "'.$finalQuotTransfer['mealplanQuotationId'].'"');
							$mQuotData=mysqli_fetch_array($rsh);
							
							$mealplaneDates = date('d M, Y',strtotime($finalQuoteMealPlanData['fromDate']));
							$Ecity = getDestination($finalQuoteMealPlanData['destinationId']);
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $mealplaneDates;  ?></td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($finalQuoteMealPlanData['mealPlanName']).', '.($mQuotData['mealType'] == 1)?'Lunch':'Dinner';  ?></td>
								</tr>

								<tr>
									<td width="15%">Remarks</td>
									<td width="3%" align="center">:</td>
									<td width="82%"><?php echo strip($finalQuoteMealPlanData['specialRequest']);  ?></td>
								</tr>
							</table><br />
							<?php
						}
					}

					// visa services start
					$b="";
					$b=GetPageRecord('*','finalQuoteVisa',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($b) > 0){
						while($finalQuoteVisaData=mysqli_fetch_array($b)){
							$d="";
							
							$d=GetPageRecord('*','visaCostMaster',' id="'.$finalQuoteVisaData['visaNameId'].'"');
							$visaData=mysqli_fetch_array($d);
							
							$supplierId = $finalQuoteVisaData['supplierId'];
							$entranceId = $entranceQuotData['visaNameId'];
							
							$rsh="";
							$rsh=GetPageRecord('*','visaTypeMaster',' id="'.$finalQuoteVisaData['visaTypeId'].'"');
							$visaTypeData=mysqli_fetch_array($rsh);
							
								$visaDates = date('d M,Y',strtotime($finalQuoteVisaData['fromDate']));
							
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $visaDates; ?></td>
									<td width="3%" align="center">:</td>
									<td width="50%"><?php echo strip($visaData['name']);  ?></td>
									<td width="32%"><?php echo strip($visaTypeData['name']);  ?></td>
								</tr>
							</table><br />
							<?php
						}
					}

					// passport services
					$b="";
					$b=GetPageRecord('*','finalQuotePassport',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($b) > 0){
						while($finalQuotePassData=mysqli_fetch_array($b)){
							$d="";
							
							$d=GetPageRecord('*','passportCostMaster',' id="'.$finalQuotePassData['passportNameId'].'"');
							$passData=mysqli_fetch_array($d);
							
							$rsh="";
							$rsh=GetPageRecord('*','visaTypeMaster',' id="'.$finalQuotePassData['passportTypeId'].'"');
							$passTypeData=mysqli_fetch_array($rsh);
							
							$passDates = date('d M,Y',strtotime($finalQuotePassData['fromDate']));
							
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $passDates; ?></td>
									<td width="3%" align="center">:</td>
									<td width="50%"><?php echo strip($passData['name']);  ?></td>
									<td width="32%"><?php echo strip($passTypeData['name']);  ?></td>
								</tr>
							</table><br />
							<?php
						}
					}

					// passport services
					$b="";
					$b=GetPageRecord('*','finalQuoteInsurance',' quotationId="'.$quotationData['id'].'" and supplierId = "'.$supplierDataa['id'].'" order by id asc');
					if(mysqli_num_rows($b) > 0){
						while($finalQuoteInsData=mysqli_fetch_array($b)){
							$d="";
							
							$d=GetPageRecord('*','insuranceCostMaster',' id="'.$finalQuoteInsData['insuranceNameId'].'"');
							$insData=mysqli_fetch_array($d);
							
							$rsh="";
							$rsh=GetPageRecord('*','InsuranceTypeMaster',' id="'.$finalQuoteInsData['insuranceTypeId'].'"');
							$insTypeData=mysqli_fetch_array($rsh);
							
							$insDates = date('d M,Y',strtotime($finalQuoteInsData['fromDate']));
							
							
							?>
							
							<table width="100%" border="1" cellspacing="0" cellpadding="3">
								<tr>
									<td width="15%"><?php echo $insDates; ?></td>
									<td width="3%" align="center">:</td>
									<td width="50%"><?php echo strip($insData['name']);  ?></td>
									<td width="32%"><?php echo strip($insTypeData['name']);  ?></td>
								</tr>
							</table><br />
							<?php
						}
					}

				} ?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="top">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td align="right"><strong><?php echo $assignTo; ?></strong></td>
			</tr>
			<tr>
				<td align="right">AUTHORISED SIGNATORY</td>
			</tr>
			<tr>
				<td>Bill Us For The Above Services &amp; Collect All  Extras Directly.</td>
			</tr>
			<tr>
				<td align="center">ISSUED SUBJECT TO TERMS AND CONDITIONS OVERLEAF</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
			</tr>
			<!-- <tr>
				<td align="center"><a href="http://www.deboxglobal.com/travcrm.html" target="_blank" style="color:#666666; font-size:9px;">Genrated by TravCRM</a></td>
			</tr> -->
		</table>
	</div>
	<?php } ?>