<?php 
include "inc.php";

$rsp1=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$_REQUEST['quotationId'].'"');
$quotationData=mysqli_fetch_array($rsp1);
$noOfPax = $quotationData['adult']+$quotationData['child'];
$rsp=GetPageRecord('*',_QUERY_MASTER_,'id="'.$quotationData['queryId'].'"');
$resultlists=mysqli_fetch_array($rsp);

$tourId  = makeQueryTourId($resultlists['id']);
$bookingId = makeQueryId($resultlists['id']);


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
// echo $fullurl;
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
		<tr>
			<td align="center"><strong>Check Hotel Availability</strong></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><table width="100%" border="0" cellspacing="0" cellpadding="2" >
            	<tr> 
                <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                	<tr>
                		<td><strong>To:&nbsp;</strong><a href=""><strong><?php echo $supplierDataa['name']; ?></strong></a></td>
					</tr>
					<tr><td><strong>Address&nbsp;:&nbsp;</strong><?php echo $resAddress['address']; ?></td></tr>
					<tr> <td><strong>Contact&nbsp;Person&nbsp;:&nbsp;</strong><?php echo $supno['contactPerson']; ?></td></tr>
					<tr><td><strong>Phone&nbsp;:&nbsp;</strong><?php echo decode($supno['phone']); ?></td></tr>
					<tr><td><strong>Email&nbsp;:&nbsp;</strong><?php echo decode($supno['email']); ?></td></tr>
					</table>
                </td>
                <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr>
					<td  align="left"><strong>Tour No&nbsp;:&nbsp;</strong><?php if($resultlists['queryStatus']==3){ echo makeQueryTourId($resultlists['id']); }else{ echo 'N/A'; }; ?></td>
					</tr>
					<tr>
					<td  align="left"><strong>Booking No&nbsp;:&nbsp;</strong><?php echo makeQueryId($resultlists['id']); ?></td>
					</tr>
					<tr><td align="left"><strong>Date&nbsp;:&nbsp;</strong><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td></tr>
					<tr><td><strong>Lead &nbsp;Pax&nbsp;Name&nbsp;:&nbsp;</strong><?php echo $resultlists['leadPaxName']; ?></td></tr>
					<tr><td align="left"><strong>Total&nbsp;Pax&nbsp;:&nbsp;</strong><?php echo $noOfPax; ?></td></tr> 
					</table>
                </td>
            </tr></table>
        </td></tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>The Reservation Manager,<br /><br /><br /><br />
				
				<!-- REFERENCE: -->
				 <?php
				  // echo showClientTypeUserName($resultlists['clientType'],$resultlists['companyId']); 
				  ?> 
				 <!-- / -->
				  <?php
				   // echo $tourId;
				    ?>
				  <!-- <br /><br /> -->

				Dear Sir / Madam,<br /><br /> 
				Please confirm accommodation for the above mentioned client/s as per details below :<br /></td>
		</tr>
		<!-- code start here -->
		<tr><td><table width="100%" border="1" cellspacing="0" cellpadding="3">
			<?php

			$rr=GetPageRecord('supplierId',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$_REQUEST['quotationId'].'" and supplierMasterId="'.$_REQUEST['supplierId'].'"'); 
			$hotelDataq=mysqli_fetch_array($rr);

			$ddd=GetPageRecord('*',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelDataq['supplierId'].'"');   
			$hotelData=mysqli_fetch_array($ddd);

			$hotcpm = GetPageRecord('*','hotelContactPersonMaster','corporateId="'.$hotelData['id'].'" and division=3');
			$hotelcpmData=mysqli_fetch_assoc($hotcpm);
			?>	
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
			<img style="vertical-align: bottom;" src="images/hotelStar.png" alt="Hotel Star" width="18" height="18">

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
			<td colspan="11" style="text-align: center;font-weight: 600;font-size: 13px;">
			<?php echo $hotelData['hotelName']; ?>	
			</td>	
			</tr>
			<tr class="maintd">
			<td style="font-weight: 600">Destination</td>
			<td style="font-weight: 600">From</td>
			<td style="font-weight: 600">To</td>
			<td style="font-weight: 600">Nights</td>
			<td style="font-weight: 600">Rooms</td>
			<!-- <td style="font-weight: 600">DBL</td>
			<td style="font-weight: 600">TPL</td>
			<td style="font-weight: 600">Twin</td>
			<td style="font-weight: 600">EBA</td>
			<td style="font-weight: 600">Quad</td
			<td style="font-weight: 600">Teen</td>
			<td style="font-weight: 600">CWBed</td>
			<td style="font-weight: 600">CNBed</td>
			<td style="font-weight: 600">SixB</td>
			<td style="font-weight: 600">EightB</td>
			<td style="font-weight: 600">TenB</td> -->

			<td style="font-weight: 600">Room&nbsp;Type</td>
			<td style="font-weight: 600">Meal&nbsp;Plan</td>
			</tr>
			<?php
			$supplierData=GetPageRecord('supplierId',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$_REQUEST['quotationId'].'" and supplierMasterId="'.$_REQUEST['supplierId'].'"');   
			$supplierDataq=mysqli_fetch_array($supplierData);

			$rr=GetPageRecord('*,min(fromDate) as fromDate,DATE_ADD(max(toDate) , INTERVAL 1 DAY) as toDate',_QUOTATION_HOTEL_MASTER_,'quotationId="'.$_REQUEST['quotationId'].'" and supplierId="'.$supplierDataq['supplierId'].'" group by supplierId,roomType,mealPlan,singleNoofRoom,doubleNoofRoom,tripleNoofRoom,twinNoofRoom,startDayDate order by fromDate asc');   
			while($hotelDataq=mysqli_fetch_array($rr)){

			$d=GetPageRecord('*',_QUOTATION_MASTER_,'id="'.$hotelDataq['quotationId'].'"');   
			$QuotData=mysqli_fetch_array($d);

			$hotelNameData=GetPageRecord('id,hotelName',_PACKAGE_BUILDER_HOTEL_MASTER_,'id="'.$hotelDataq['supplierId'].'"');   
			$hotelData=mysqli_fetch_array($hotelNameData);

			$roomTypeDataq=GetPageRecord('name',_ROOM_TYPE_MASTER_,'id='.$hotelDataq['roomType'].''); 
			$roomTypeData=mysqli_fetch_array($roomTypeDataq);

			$destinationDataq=GetPageRecord('*',_DESTINATION_MASTER_,'id='.$hotelDataq['destinationId'].''); 
			$destinationData=mysqli_fetch_array($destinationDataq);

			$paxSlabDataq=GetPageRecord('*','totalPaxSlab','quotationId='.$hotelDataq['quotationId'].' and localEscort!=0 order by toRange desc limit 1'); 
			$paxSlabData=mysqli_fetch_array($paxSlabDataq);

			$mealPlanDataq=GetPageRecord('name',_MEAL_PLAN_MASTER_,'id='.$hotelDataq['mealPlan'].''); 
			$mealPlanData=mysqli_fetch_array($mealPlanDataq);

			$originData = new DateTime($hotelDataq['fromDate']);
			$targetDate = new DateTime($hotelDataq['toDate']);
		
			$interval = $originData->diff($targetDate);
			$nights = $interval->days;   

			?>
			<tr class="secondtd">
			<td><?php echo $destinationData['name']; ?></td>
			<td><?php echo date('d-m-Y',strtotime($hotelDataq['fromDate'])); ?></td>
			<td><?php echo date('d-m-Y',strtotime($hotelDataq['toDate'])); ?></td>
			<td><?php echo $nights; ?></td>
			<td><?php if($hotelDataq['escortHotelStatus'] == 1){ echo $paxSlabData['localEscort']; } else{ if($hotelDataq['singleNoofRoom']>0){ echo $hotelDataq['singleNoofRoom'].' SGL, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['doubleNoofRoom']>0){ echo $hotelDataq['doubleNoofRoom'].' DBL, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['tripleNoofRoom']>0){ echo $hotelDataq['tripleNoofRoom'].' Triple, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['twinNoofRoom']>0){ echo $hotelDataq['twinNoofRoom'].' Twin, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['extraNoofBed']>0){ echo $hotelDataq['extraNoofBed'].' EBedA, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['quadNoofRoom']>0){ echo $hotelDataq['quadNoofRoom'].' Quad, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['teenNoofRoom']>0){ echo $hotelDataq['teenNoofRoom'].' Teen, ';} } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['childwithNoofBed']>0){ echo $hotelDataq['childwithNoofBed'].' CWB, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['childwithoutNoofBed']>0){  echo $hotelDataq['childwithoutNoofBed'].' CNB, '; } } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['sixNoofBedRoom']>0){ echo $hotelDataq['sixNoofBedRoom'].' SixB, ';} } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['eightNoofBedRoom']>0){ echo $hotelDataq['eightNoofBedRoom'].' EightB, ';} } ?>
			<?php if($hotelDataq['escortHotelStatus'] == 1){ echo '_'; } else{ if($hotelDataq['tenNoofBedRoom']>0){ echo $hotelDataq['tenNoofBedRoom'].' TenB, '; } } ?></td>

			<td><?php echo $roomTypeData['name']; ?></td>

			<td><?php echo $mealPlanData['name']; ?></td>	
			</tr>
			<?php } ?>
			<tr>
			<td colspan="9">&nbsp;</td>	
			</tr>
			</table>
			</td>
		</tr>

		<tr >
			<table>
				<tr>
					<td> <span style="font-weight: 800;">Billing Instructions -</span> <span> <?php  echo ''; ?> </span></td>  
					
				</tr>
			</table>
		</tr>
		<!-- <tr>
			<td></td>
		</tr> -->





		
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Your confirmation for the above requested accommodation on this mail shall be highly appreciated.<br /><br />
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

