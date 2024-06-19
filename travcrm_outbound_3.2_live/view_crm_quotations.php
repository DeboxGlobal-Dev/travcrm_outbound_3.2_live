<?php
if ($_REQUEST['id'] != '') {
	// 
	$where2 = '';
	$rs2 = '';
	$select2 = '*';
	$where2 = 'id="' . decode($_REQUEST['id']) . '" ';
	$rs2 = GetPageRecord($select2, _QUOTATION_MASTER_, $where2);
	$resultpage2 = mysqli_fetch_array($rs2);
	if ($resultpage2['quotationType'] == '2') {
		$quotationTypeN = "Multiple Hotel Category";
	} else {
		$quotationTypeN = "Single Hotel Category";
	}
	$quotationSubject = $resultpage2['quotationSubject'];
	$quotationleadPaxName = $resultpage2['leadPaxName'];
	$querytypeId = $resultpage2['queryType'];


	$val = $resultpage2['viewQuotation'];
	$night = $resultpage2['night'];
	$editadult = clean($resultpage2['adult']);
	$editchild = clean($resultpage2['child']);
	$editguest1 = clean($resultpage2['guest1']);
	$lastId = $resultpage2['id'];
	$lastqueryidmain = $resultpage2['id'];
	$paxrange = trim($editadult + $editchild);
	$q_token = $resultpage2['q_token'];
}
if($q_token=='' || strlen($q_token)<1){
	$q_token = mt_rand(10000000, 99999999);
	$update = updatelisting(_QUOTATION_MASTER_, 'q_token="' . encode($q_token) . '"', 'id="'.$lastId.'"');
}

$select= '';
$where = '';
$rs = '';
 $id = $resultpage2['queryId'];
$where = 'id="'.$resultpage2['queryId'].'"';
$rs = GetPageRecord('*', _QUERY_MASTER_, $where);
$resultpage = mysqli_fetch_array($rs);
$dayWise = $resultpage['dayWise'];
$travelType = $resultpage['travelType'];

// update quotation with nights 
$sql_check = GetPageRecord('min(srdate) as fromDate, max(srdate) as toDate, count(id) as nights ', 'newQuotationDays', 'quotationId="' .decode($_GET['id']).'" and addstatus=0');
if (mysqli_num_rows($sql_check) > 0) {

	$QueryDaysData1 = mysqli_fetch_array($sql_check);
	$nights = ($QueryDaysData1['nights'] - 1);
	if ($_REQUEST['alt'] == 3) {

		$fromDate = date('Y-m-d', strtotime($QueryDaysData1['fromDate']));
		$toDate = date('Y-m-d', strtotime($QueryDaysData1['toDate']));

		$namevalue = 'fromDate="' . $QueryDaysData1['fromDate'] . '",toDate="' . $QueryDaysData1['toDate'] . '",night="' . $nights . '",isRegenerated=0';
		$update = updatelisting(_QUOTATION_MASTER_, $namevalue, 'id="' . decode($_GET['id']) . '"');
		//header('location:showpage.crm?module=quotations&view=yes&id='.$_GET['id'].'');
		//exit();

	} else {  
		$namevalue = 'night="' . $nights . '"';
		$update = updatelisting(_QUOTATION_MASTER_, $namevalue, 'id="' . decode($_GET['id']) . '"');
	}
}

$where2 = '';
$rs2 = '';
$select2 = '*';
$where2 = 'id="' . decode($_GET['id']) . '"';
$rs2 = GetPageRecord($select2, _QUOTATION_MASTER_, $where2);
$resultpage2 = mysqli_fetch_array($rs2);


$quotationIdShow = makeQuotationId($resultpage2['id']);
$quotationId = $resultpage2['id'];
$queryId = $resultpage2['queryId'];


$fromDate2 = date("d-m-Y", strtotime($resultpage2['fromDate']));
$toDate2 = date("d-m-Y", strtotime($resultpage2['toDate']));
$night2 = $resultpage2['night'];

if($resultpage2['moduleType'] == 4){
    
    $adult2 = 3;
    $child2 = 0;
    $infant2 = 0;
    

    $sglRoom2 = 1;
    $dblRoom2 = 1;
}else{
    $adult2 = clean($resultpage2['adult']);
    $child2 = clean($resultpage2['child']);
    $infant2 = clean($resultpage2['infant']);


    $sglRoom2 = clean($resultpage2['sglRoom']);
    $dblRoom2 = clean($resultpage2['dblRoom']);
} 
$twinRoom2   = clean($resultpage2['twinRoom']);
$tplRoom2 = clean($resultpage2['tplRoom']);
$quadNoofRoom2 = clean($resultpage2['quadNoofRoom']);
$sixNoofBedRoom2 = clean($resultpage2['sixNoofBedRoom']);
$eightNoofBedRoom2 = clean($resultpage2['eightNoofBedRoom']);
$tenNoofBedRoom2 = clean($resultpage2['tenNoofBedRoom']);
$teenNoofRoom2 = clean($resultpage2['teenNoofRoom']);
$extraNoofBed2 = clean($resultpage2['extraNoofBed']);
$CWBed2 = clean($resultpage2['childwithNoofBed']);
$CNBed2 = clean($resultpage2['childwithoutNoofBed']);



?>
<style>
	#mainquationboxload .addtopaboxlist .gridtable td {
		padding: 0px 4px !important;
	}

	#mainquationboxload .addeditpagebox .griddiv .gridlable {
		margin-top: 0px !important;
	}

	#mainquationboxload #addTriffRoom .addGreenHeader {
		display: none;
	}

	#mainquationboxload .gridtable td ,#mainquationboxload .gridtable th {
		padding: 5px 12px 5px !important;
		border-bottom: #e8e8e8 0px solid !important;
	}

	#mainquationboxload .bluembutton {
		background-color: #ffc115;
		padding: 8px 9px !important;
		font-size: 12px !important;
	}

	#mainquationboxload .addeditpagebox .griddiv .gridfield {
		font-size: 13px !important;
		padding: 5px !important;
	}

	#mainquationboxload .addeditpagebox .griddiv {
		border-bottom: 0px #f2fff7 solid !important;
	}
</style>
<!-- <link href="css/main.css" rel="stylesheet" type="text/css" /> -->
<script src="tinymce/tinymce.min.js"></script>
<!-- <script src="js/zebra_datepicker.js"></script> -->
<script type="text/javascript">
	// function showDays(firstDate, secondDate) {
	// 	var startDay = new Date(firstDate);
	// 	var endDay = new Date(secondDate);
	// 	var millisecondsPerDay = 1000 * 60 * 60 * 24;
	// 	var millisBetween = startDay.getTime() - endDay.getTime();
		// var days = millisBetween / millisecondsPerDay;
	// 	// Round down.
	// 	return (Math.floor(days));
	// }

	// function toTimestamp(strDate) {
	// 	var datum = Date.parse(strDate);
	// 	return datum / 1000;
	// }
</script>
<style>
	body {
		background-color: #eae9ee !important;
	}

	.style1 {
		font-weight: bold
	}
</style>
<?php
if ($resultpage2['isTourEx'] == 0) {
	$displayId = makeQueryId($resultpage['id']);
} else {
	$displayId = makeExtensionId($resultpage['displayId']);
}
?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<?php if ($resultpage['moduleType'] == 1) { ?>
			<td width="15%" align="left" valign="top" style="background-color:#2c343f;color:#fff;">
				<div class="innerdiv" style="margin-top: 60px; font-size:12px;">
					<div class="contentbox" style="background-color: rgba(0,0,0,0.2);">
						<div class="lables">
							<?php echo date('j F Y', $resultpage['dateAdded']); ?> &nbsp;<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('h:i A', $resultpage['dateAdded']); ?></div>
						<div style="font-size:24px;" class="statustbs"><?php echo $displayId; ?> <?php if ($resultpage['queryPriority'] == 1 || $resultpage['queryPriority'] == 0) {
							} ?><?php if ($resultpage['queryPriority'] == 2) {
							} ?><?php if ($resultpage['queryPriority'] == 3) {
							} ?></div>
						<?php if ($resultpage['queryStatus'] == 3 && $resultpage['queryConfirmingDate'] || $resultpage['queryStatus'] == 20 && $resultpage['queryConfirmingDate']) { ?><div style="font-size:16px;" class="statustbs">Tour Id - <?php echo makeQueryTourId($resultpage['id']); ?> </div><?php } ?>
					</div>
					<div class="contentbox">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="display:none;">
							<tr>
								<td colspan="2">
									<div class="lables">Check In</div>
									<?php echo showdate($resultpage['fromDate']); ?>
								</td>
								<td>
									<div class="lables">Check Out</div>
									<?php echo showdate($resultpage['toDate']); ?>
								</td>
							</tr>
						</table>
					</div>
					<div class="contentbox" style=" background-color:#cccccc1a;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top"><i class="fa fa-user-circle-o" aria-hidden="true" style="font-size: 28px;color: #ffffff73; margin-top:2px;"></i></td>
								<td width="85%" align="left" valign="top" style="padding-left:5px;">
									<div style="margin-bottom:2px; font-size:12px;"><?php echo str_replace(' ','&nbsp;',showClientTypeUserName($resultpage['clientType'], $resultpage['companyId'])); ?></div>
									<div style="margin-bottom:2px; font-size:12px;"><?php echo $resultpage['guest1phone']; ?></div>
								</td>
							</tr>
							<!-- market Type -->
							<tr>
								<td colspan="2" align="left" valign="top">
									<div style="background-color:#ffffff; padding: 5px 5px; border-radius: 3px; margin-top: 5px;">
										<!-- mix-blend-mode: difference; -->
										<div style="padding: 5px; border-radius: 3px; color:<?php echo getMaketTypeColor($resultpage['id']); ?>;">Market&nbsp;Type:&nbsp;<?php echo str_replace(' ','&nbsp;',getMaketTypeName($resultpage['id'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div style="padding: 5px; border-radius: 3px; color:<?php echo getMaketTypeColor($resultpage['id']); ?>;">Query&nbsp;Type:&nbsp;<?php echo ($resultpage['paxType'] == 1)?'GIT':'FIT'; ?>&nbsp;&nbsp;&nbsp;&nbsp;</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2" align="left" valign="top"><?php if ($getphone != '') { ?>
										<div style="margin-bottom:2px; font-size:12px;"><a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=&source=&data=" target="_blank"><img src="images/whatsapp-button.png" width="107" border="0" /></a></div>
									<?php } ?>
								</td>
							</tr>
						</table>
					</div>
					<?php if($querytypeId!=13){ ?>
					<div class="contentbox" style="padding:5px; background-color:#232a32;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td colspan="2">
									<div class="lables">Start.&nbsp;City</div> <?php
									$cityIdQuery = "";
									$cityIdQuery = GetPageRecord('cityId', 'newQuotationDays', ' queryId="' . $queryId . '" and quotationId="' . $quotationId . '"  and addstatus=0 order by srdate asc');
									$cityIdData = mysqli_fetch_array($cityIdQuery);
									echo getDestination($cityIdData['cityId']);
									?>
								</td>
								<td align="center">
									<div class="lables">Nights</div>
									<?php echo $nights; ?>
								</td>
								<td align="right">
									<div class="lables">End&nbsp;City</div>
									<?php
									$cityIdQuery = "";
									$cityIdQuery = GetPageRecord('cityId', 'newQuotationDays', ' queryId="' . $queryId . '" and quotationId="' . $quotationId . '" and addstatus=0  order by srdate desc');
									$cityIdData = mysqli_fetch_array($cityIdQuery);
									echo getDestination($cityIdData['cityId']);
									?>
								</td>
							</tr>
						</table>
					</div>
					<div class="contentbox" style="padding:5px;">

						<table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#a4afb9" class="boxc" style="font-size:11px;">
							<tr>
								<td width="8%" align="center" valign="top" class="he">&nbsp;</td>
								<td width="30%" align="left" valign="top" class="he">Destination</td>
								<?php if ($resultpage2['dayWise'] != 2) { ?><td width="31%" align="left" valign="top" class="he">Date</td><?php } ?>
							</tr>
							<?php
							$n = 1;
							$rs1 = "";
							//echo ' queryId="'.$queryId.'" and quotationId="'.$quotationId.'" order by srdate asc';
							$rs1 = GetPageRecord('*', 'newQuotationDays',' quotationId="'.$quotationId.'" and addstatus=0 order by srdate asc');
							while ($packageQueryData = mysqli_fetch_array($rs1)) {
							?>
								<tr>
									<td align="center" valign="top">Day&nbsp;<?php echo $n; ?></td>
									<td align="left" valign="top"><?php echo getDestination($packageQueryData['cityId']); ?></td>
									<?php if ($resultpage2['dayWise'] != 2) { ?> <td align="left" valign="top"><?php echo date('d-m-Y', strtotime($packageQueryData['srdate'])); ?></td><?php } ?>
								</tr>
							<?php $n++;
							}  ?>
						</table>
					</div>
					<?php } ?>
					<div class="contentbox" style="padding:0px;">
						<table width="100%" border="0" cellpadding="2" cellspacing="0">
							<tr>
							
								<td align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Adult</div><?php echo $adult2; ?>
									</div>
								</td>
								<td align="center">
									<div style="background-color:#232a32; margin-right:2px;padding:4px;">
										<div class="lables">Child</div><?php echo $child2; ?>
									</div>
								</td>  
								<td width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Infant</div><?php echo $infant2; ?>
									</div>
								</td>
							</tr>   
						</table>
					</div>


					<div class="contentbox" style="display:none;">
						<div class="lables">Occupancy Type</div>
						<?php if ($resultpage['occupancyType'] == 1) {
							$occup = 'Single';
						}
						if ($resultpage['occupancyType'] == 2) {
							$occup = 'Double';
						}
						if ($resultpage['occupancyType'] == 3) {
							$occup = 'Tripale';
						}
						echo $occup; ?>
					</div>

					<?php
					if ($resultpage['childrensage'] != '') {
					?>
						<div class="contentbox" style="padding:5px;">
							<table width="100%" border="0" cellpadding="2" cellspacing="0">
								<tr>
									<td align="left">
										<?php

										$string = preg_replace('/\.$/', '', $resultpage['childrensage']);
										$chi = 1;
										$array = explode(',', $string);
										foreach ($array as $value) {
											if ($value != '') {
										?>
												<div style="background-color:#232a32; margin-right:2px; padding:4px;">
													<div class="lables">Child <?php echo $chi; ?>: <span style="color:#FFF;"><?php echo $value; ?></span> Years </div>
												</div>
										<?php
												$chi++;
											}
										}



										?>
									</td>
								</tr>
							</table>
						</div>
					<?php } ?>
					<!-- ==================================================================== -->

					<hr />
					<?php  
					if($resultpage2['adult']>0){
					?>
					<div class="contentbox" style="padding:0px;">
						<table width="100%" border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">SGL</div><?php echo $sglRoom2; ?>
									</div>
								</td>
								<td width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">DBL</div><?php echo $dblRoom2; ?>
									</div>
								</td>
								<td width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">TPL</div><?php echo $tplRoom2; ?>
									</div>
								</td>
							</tr>
							<tr> 
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">CWB</div><?php echo $CWBed2; ?>
									</div>
								</td>
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">CNB</div><?php echo $CNBed2; ?>
									</div>
								</td>
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">E.Bed</div><?php echo $extraNoofBed2; ?>
									</div>
								</td> 
							</tr>
							<tr>
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">TWIN</div><?php echo $twinRoom2; ?>
									</div>
								</td> 
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Teen BR</div><?php echo $teenNoofRoom2; ?>
									</div>
								</td>
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Quad BR</div><?php echo $quadNoofRoom2; ?>
									</div>
								</td>
							</tr>  
							<tr>
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Six BR</div><?php echo $sixNoofBedRoom2; ?>
									</div>
								</td>
								<td  width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Eight BR</div><?php echo $eightNoofBedRoom2; ?>
									</div>
								</td>
								<td  width="33%" align="center" >
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Ten BR</div><?php echo $tenNoofBedRoom2; ?>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<?php } ?>
					<div class="contentbox" style="padding:0px;">
						<table width="100%" border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables"> Budget</div>

										<?php if ($resultpage['expectedSales'] == '' || $resultpage['expectedSales'] == 0) {
											echo "-";
										} else {
											echo ($resultpage['expectedSales']);
										} ?>
									</div>
								</td>

								<td width="33%" align="center">
									<div style="background-color:#232a32; margin-right:2px; padding:4px;">
										<div class="lables">Category</div>
										<?php
										$rs = '';
										$rs = GetPageRecord('*', 'hotelCategoryMaster', ' id=' . $resultpage['hotelCategory'] . '  ');
										while ($resListing = mysqli_fetch_array($rs)) {
											echo $resListing['name'];
										}
										if ($resultpage['hotelCategory'] == '0' || $resultpage['hotelCategory'] == '') {
											echo '-';
										} ?>
									</div>
								</td>
							</tr>
						</table>
					</div>

					<!-- ==================================================================== -->

					<!-- ==================================================================== -->
					<!-- <td width="10%" align="left" valign="top" class="">
					<div class="innerdiv"> -->
					<?php 	

					$leadsourceName = '';
					if($resultpage['leadsource']!=0){
						$leadSourceQuery = GetPageRecord('*',_LEADSSOURCE_MASTER_,'id="'.$resultpage['leadsource'].'"');
						$leadSourceD = mysqli_fetch_array($leadSourceQuery);
						$leadsourceName = $leadSourceD['name'];
						?>
						<div class="contentbox">
							<div class="lables">Lead Source</div>
							<?php echo $leadsourceName; ?>
						</div>
						<?php 	
					}
					?>

						<div class="contentbox" style="padding:0px;"></div>
						<?php if ($resultpage['clientType'] == 222) { ?>

							<div class="contentbox">

								<div class="lables ">Meal Preference</div> <?php
								$select = '*';
								$where = ' id="' . $contantnamemain['mealPreference'] . '"  ';
								$rs = GetPageRecord($select, 'mealPreference', $where);
								while ($resListing = mysqli_fetch_array($rs)) {
								echo $resListing['name'];
								}
								if ($contantnamemain['name'] == '0') {
								echo 'NA';
								} ?>
								<br />
								<br />
								<div class="lables">Physical Condition</div> <?php
								$select = '*';
								$where = ' id="' . $contantnamemain['physicalCondition'] . '"  ';
								$rs = GetPageRecord($select, 'physicalCondition', $where);
								while ($resListing = mysqli_fetch_array($rs)) {
								echo $resListing['name'];
								}
								if ($contantnamemain['name'] == '0') {
								echo 'NA';
								} ?>
								<br />
								<br />
								<div class="lables">Seat Preference</div> <?php echo $contantnamemain['seatPreference'];
								if ($contantnamemain['seatPreference'] == '') {
									echo 'NA';
								} ?>
							</div>
						<?php } ?>
						<?php if ($resultpage['tourType'] == '' || $resultpage['tourType'] == '0') {
						} else { ?>
							<div class="contentbox queryleft2">
								<div class="lables">Tour Type</div> <?php
								$select = '*';
								$where = ' id="' . $resultpage['tourType'] . '"  ';
								$rs = GetPageRecord($select, _TOUR_TYPE_MASTER_, $where);
								while ($resListing = mysqli_fetch_array($rs)) {
									echo $resListing['name'];
								} ?>
							</div>
						<?php } ?>
						<?php if ($resultpage['assignTo'] != '') { ?>
							<div class="contentbox queryleft2">
								<div class="lables">Operation Person</div> <?php
								$selectu = '*';
								$whereu = ' id="' . $resultpage['assignTo'] . '"  ';
								$rsu = GetPageRecord($selectu, _USER_MASTER_, $whereu);
								while ($resListingu = mysqli_fetch_array($rsu)) {
									echo $resListingu['firstName'] . ' ' . $resListingu['lastName'];
								} ?>
							</div>
						<?php } ?>

						<?php if (trim($resultpage['additionalInfo']) != '') { ?>
							<div class="contentbox">
								<div class="lables">Additional Info</div>
								<?php echo  stripslashes($resultpage['additionalInfo']); ?>
							</div>
						<?php } ?>

						<?php if (trim($resultpage['vehicleId']) > 0) {
							$rss = GetPageRecord('*', _VEHICLE_MASTER_MASTER_, ' 1 and id="' . $resultpage['vehicleId'] . '" order by id asc');
							$resListingv = mysqli_fetch_array($rss);
						?>
							<div class="contentbox">
								<div class="lables">Vehicle Prefrence</div>
								<?php echo  stripslashes($resListingv['model']); ?>
							</div>
						<?php } ?>
					</div>
				</td>
			<?php } ?>
					<!-- ==================================================================== -->



					
		<td width="85%" align="left" valign="top">
			<div class="contentboxaddagent">

				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<!-- Subject and leadpax Name -->
						<tr>
							<td style="font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Subject</td>	
							<td style="font-size:16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lead Pax Name</td>
							</tr>
				
						<tr>
							<td width="45%">
								<div id="editNameBox" style="display:none;">
									<input type="text" id="editName" class="qtNameInput" value="<?php echo stripslashes($quotationSubject); ?>">
									<div class="qtNameSave" onClick="saveNameBox();">save</div>
									<div class="qtNameCancel" onClick="$('#showNameBox').show();$('#editNameBox').hide();">Cancel</div>
								</div>
								<div id="showNameBox" class="qtNameBox">
									<span class="fa fa-pencil" onClick="$('#showNameBox').hide();$('#editNameBox').show();" style="border: 1px solid;border-radius: 4px;padding: 2px 5px;cursor:pointer;"></span>
									<div id="loadNameBox" class="qtName"><?php echo stripslashes($quotationSubject); ?></div>
								</div>
							</td>
							<td width="30%">
									<div id="editNameBoxLead" style="display:none;">
										<input type="text" id="editNamelead" class="qtNameInputLead" value="<?php if($quotationleadPaxName==''){ echo stripslashes($resultpage['leadPaxName']);
										}else{ echo stripslashes($quotationleadPaxName); }  ?>">
										<div class="qtNameLeadSave" onClick="saveNameBoxLead();">save</div>
										<div class="qtNameLeadCancel" onClick="$('#showNameBoxLead').show();$('#editNameBoxLead').hide();">Cancel</div>
									</div>
									<div id="showNameBoxLead" class="qtNameBoxlead">
										<span class="fa fa-pencil" onClick="$('#showNameBoxLead').hide();$('#editNameBoxLead').show();" style="border: 1px solid;border-radius: 4px;padding: 2px 5px;cursor:pointer;"></span>
										<div id="loadLeadNameBox" class="qtLeadName"><?php if($quotationleadPaxName==''){
											echo stripslashes($resultpage['leadPaxName']);
										}else{
											echo stripslashes($quotationleadPaxName);
										}  ?>
										</div>
									</div>
								</td>
							<style>
								.lables{
									font-size: 11px;
										color: #a4afb9;
										margin-bottom: 2px;
										text-transform: uppercase;
									}
								
								.queryleft2{
									padding: 8px 15px;
									color: #fff;
									font-size: 14px;
									border-bottom: 1px #373d46 solid;
									overflow: hidden;
								}
								.dropbtn {
									background-color: #67b069;
									color: white;
									padding: 7px;
									font-size: 12px;
									border: none;
									cursor: pointer;
								}

								.dropdown {
									position: relative;
									display: inline-block;
									float: right;
									cursor: pointer;
								}

								.dropdown-content {
									display: none;
									position: absolute;
									background-color: #f1f1f1;
									box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
									z-index: 1;
									font-size: 12px;
									right: 0;
									overflow: visible;
									text-align: left;
									width: fit-content;
								}

								.dropdown-content a {
									color: black;
									padding: 10px 26px 10px 10px;
									text-decoration: none;
									display: block;
									float: left;
									text-align: left;
									width: 187px;
									background-color: #FFFFFF;
									border-bottom: 1px solid #cccccc30;


								}

								.dropdown-content a:hover {
									background-color: #ddd;
								}

								.dropdown:hover .dropdown-content {
									display: block;
								}

								.dropdown:hover .dropbtn {
									background-color: #3e8e41;
								}
							</style>
							<td width="25%" align="right">
								<?php if ($resultpage['moduleType'] == 1 && $resultpage['queryStatus']!=3) { ?>
									<!-- <div id="rightquerylink">
										<a href="#" onclick="myFunction122(this)" class="dropbtn">
											<i class="fa fa-plus-square" aria-hidden="true" style="color:#f8f8f8;"></i>
											<i class="fa fa-minus-square" aria-hidden="true" style="color:#f8f8f8;display:none;"></i>&nbsp;&nbsp;Tour Log</a>
										<div id="myDropdown122" class="dropdown-content" style="max-width:145px;">
											<?php
											// $thisQueryId = $displayId;
											// $dirname =  'log_generate/';
											// $images = scandir($dirname);
											// krsort($images);
											// //	print_r($images);
											// foreach (array_slice($images, 0, 5) as $file) {
											// 	$fileQueryId = explode('-', $file);
											// 	if (substr($file, -5) == ".html" && $fileQueryId[0] == $thisQueryId) {
											?>
													<a href="<?php echo $fullurl; ?>log_generate/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
											<?php
											// 	}
											// }
											?>

										</div>
										<style>
											#rightquerylink {
												position: relative;
											}

											#rightquerylink a {
												padding: 5px 10px;
												margin: 0 10px;
												font-size: 14px;
												position: relative;
												background-color: #233a49;
												color: #f8f8f8 !important;
											}

											#rightquerylink .dropdown-content {
												display: none;
												position: absolute;
												background-color: #233a49;
												overflow: auto;
												box-shadow: none;
												z-index: 1;
												padding: 0 10px;
												top: 23px;
												min-width: 145px;
												left: 5px;
											}

											#rightquerylink .dropdown-content a {
												padding: 8px 0px;
												display: block;
												margin: 0;
												width: 100%;
											}

											#rightquerylink .show {
												display: block;
											}
										</style>
										<script>
											/* When the user clicks on the button,
				toggle between hiding and showing the dropdown content */
											function myFunction122(ele) {
												$("#myDropdown122").toggle("show");
												// if(document.getElementById("myDropdown122").style.display == "block"){
												$(ele).children('.fa-minus-square').toggle("show");
												$(ele).children('.fa-plus-square').toggle("show");
												// }
											}

											// Close the dropdown if the user clicks outside of it
											window.onclick = function(event) {
												if (!event.target.matches('.dropbtn')) {
													var dropdowns = document.getElementsByClassName("dropdown-content");
													var i;
													for (i = 0; i < dropdowns.length; i++) {
														var openDropdown = dropdowns[i];
														if (openDropdown.classList.contains('show')) {
															openDropdown.classList.remove('show');
														}
													}
												}
											}
										</script>
									</div> -->
									<div id="rightquerylink">
										<a href="#" onclick="myFunction121()" class="dropbtn"><i class="fa fa-plus-square" aria-hidden="true" style="color:#f8f8f8;"></i>&nbsp;&nbsp;Tour Change</a>
										<div id="myDropdown121" class="dropdown-content" style="max-width:145px;">
											<a onclick="query_alertbox('action=tourDateChange&quotationId=<?php echo ($_GET['id']); ?>','450px','auto');myFunction121();"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;Change Arrival Date</a>
											<a onclick="query_alertbox('action=updatePaxRoom&quotationId=<?php echo ($_GET['id']); ?>','600px','auto');myFunction121();"><i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;Update Pax/Room</a>
											<a onclick="query_alertbox('action=modifyRoute&quotationId=<?php echo ($_GET['id']); ?>','500px','auto');myFunction121();"><i class="fa fa-road" aria-hidden="true"></i>&nbsp;&nbsp;Modify Route</a>
											<a onclick="query_alertbox('action=amendCityDay&quotationId=<?php echo ($_GET['id']); ?>','600px','auto');myFunction121();"><i class="fa fa-history" aria-hidden="true"></i>&nbsp;&nbsp;Amend City/Day</a>
										</div>
										<style>
											#rightquerylink {
												position: relative;
												float: left;
											}

											#rightquerylink a {
												padding: 5px 10px;
												margin: 0 5px;
												font-size: 14px;
												position: relative;
												background-color: #233a49;
												color: #f8f8f8 !important;
											}

											#rightquerylink .dropdown-content {
												display: none;
												position: absolute;
												background-color: #233a49;
												overflow: auto;
												box-shadow: none;
												z-index: 1;
												padding: 0 10px;
												top: 23px;
												min-width: 145px;
												left: 5px;
											}

											#rightquerylink .dropdown-content a {
												padding: 8px 0px;
												display: block;
												margin: 0;
												width: 100%;
											}

											#rightquerylink .show {
												display: block;
											}
										</style>
										<script>
											/* When the user clicks on the button,
				toggle between hiding and showing the dropdown content */
											function myFunction121() {
												$("#myDropdown121").toggle("show");
											}

											// Close the dropdown if the user clicks outside of it
											window.onclick = function(event) {
												if (!event.target.matches('.dropbtn')) {
													var dropdowns = document.getElementsByClassName("dropdown-content");
													var i;
													for (i = 0; i < dropdowns.length; i++) {
														var openDropdown = dropdowns[i];
														if (openDropdown.classList.contains('show')) {
															openDropdown.classList.remove('show');
														}
													}
												}
											}
										</script>
									</div>
								<?php } ?>
							</td>

						</tr>
						<tr>
							<td colspan="2">
								<div class="headingm" style="margin-left:20px;">
								<?Php if ($resultpage['parentQueryId'] != 0) { ?> Sub - <?php }
								
									echo $quotationIdShow; if($resultpage['queryType']<>14){ ?>&nbsp;|&nbsp;<?php echo $quotationTypeN; }
								
								
								?></div>
							</td>
							<td align="right" valign="middle">
								<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resultpage2['queryId']); ?><?php if ($resultpage2['isTourEx'] == 1) { ?>&tourextension=1<?php } else { ?>&b2bquotation=1&qtype=1<?php } ?>"> <input type="button" name="Submit22" value="Back" class="whitembutton" style="margin-right:20px;"> </a>
								<?php
								if ($resultpage2['queryId'] != '') {
									$perp = 1;
									$categorywise = 2;
									$packagewise = 3;
								?>
									<div id="selectfinalquot" style="display:none;"></div>
									<script>
										function selectFinalFun() {
											var final = $('#selectFinal :selected').val();
											if (final > 0 && final != '') {
												$('#selectfinalquot').load('frmaction.php?makefinal=' + final + '&action=makeFinalQuotation&quotationId=<?php echo ($_GET['id']); ?>&queryId=<?php echo encode($resultpage2['queryId']); ?>');
											}
										}
									</script>
								<?php }  ?>
							</td>
						</tr>
					</tbody>
				</table>
				<script type="text/javascript">
						function saveNameBox() {
							var quotationSubject = $('#editName').val();
							//alert(quotationSubject);
							$('#loadNameBox').load('query_frmaction.php?action=editQuotationName&quotationSubject=' + encodeURI(quotationSubject) + '&quotationId=<?php echo decode($_GET['id']); ?>');
							$('#showNameBox').show();
							$('#editNameBox').hide();
						}
						function saveNameBoxLead() {
								var quotationLeadPax = $('#editNamelead').val();
								//alert(quotationSubject);
								$('#loadLeadNameBox').load('query_frmaction.php?action=editQuotationLeadPaxName&quotationLeadPax='+encodeURIComponent(quotationLeadPax)+'&quotationId=<?php echo decode($_GET['id']); ?>&queryId=<?php echo $resultpage2['queryId']; ?>');
								$('#showNameBoxLead').show();
								$('#editNameBoxLead').hide();
							}
				</script>
				<style>
					.qtNameInputLead{
							height: 25px;
							width: 50%;
							padding: 2px 10px;
							border-radius: 5px;
							border: 1px solid #ddd;
						}
							
						.qtNameBoxlead,
						#editNameBoxLead{
							padding: 10px 23px;
							color: #5b9d50;
							font-size: 24px;
							font-family: raleway;
							font-weight: 600;
						}
						.qtLeadName {
							display: inline;
						}
						.qtNameLeadCancel,
						.qtNameLeadSave{
							display: inline-block;
							font-size: 15px;
							border: 1px solid #233a49;
							border-radius: 5px;
							padding: 5px 7px;
							background-color: #233a49;
							color: #f8f8f8;
							cursor: pointer;
						}
					.qtNameLeadCancel {
							background-color: red;
							border: 1px solid #ff0000;
						}


					.qtNameInput {
						height: 25px;
						width: 67%;
						padding: 2px 10px;
						border-radius: 5px;
						border: 1px solid #ddd;
					}

					.qtNameBox,
					#editNameBox {
						padding: 10px 23px;
						color: #5b9d50;
						font-size: 24px;
						font-family: raleway;
						font-weight: 600;
					}

					.qtName {
						display: inline;
					}

					.qtNameCancel,
					.qtNameSave {
						display: inline-block;
						font-size: 15px;
						border: 1px solid #233a49;
						border-radius: 5px;
						padding: 5px 7px;
						background-color: #233a49;
						color: #f8f8f8;
						cursor: pointer;
					}

					.qtNameCancel {
						background-color: red;
						border: 1px solid #ff0000;
					}
				</style>
			</div>
			<style>
				#paxslab table tr td {
					border: 1px solid #ccc;
				}

				#paxslab table tr td input,
				select {
					border: 1px solid #ccc;
					padding: 5px;
				}
			</style>
			<?php
			$escortCols=0;
			$dateAdded = date('Y-m-d H:i:s A');
			$modifyDate = date('Y-m-d H:i:s A');
			$where = 'quotationId="' . $quotationId . '" and status=1 ';
			$addnewyes = checkduplicate('totalPaxSlab', $where);

			$DF_SGL = round($sglRoom2);
			$DF_DBL = round($dblRoom2*2);
			$DF_TWN = round($twinRoom2*2);
			$DF_TPL = round($tplRoom2*3);
			$DF_QUAD = round($quadNoofRoom2*4);
			$DF_SIX = round($sixNoofBedRoom2*6);
			$DF_EIGHT = round($eightNoofBedRoom2*8);
			$DF_TEN = round($tenNoofBedRoom2*10);
			$DF_ABED = round($extraNoofBed2);
			$DF_CBED = round($CWBed2+$CNBed2+$teenNoofRoom2);
			$DF_INF = round($infant2);
			$discount_INF = round($infant2);

			if($DF_SGL>0){ 
				$escortCols=$escortCols+1;
			}if($DF_DBL>0){  
				$escortCols=$escortCols+1;
			}if($DF_TWN>0){  
				$escortCols=$escortCols+1;
			}if($DF_TPL>0){  
				$escortCols=$escortCols+1;
			}if($DF_QUAD>0){  
				$escortCols=$escortCols+1;
			}if($DF_SIX>0){  
				$escortCols=$escortCols+1;
			}if($DF_EIGHT>0){  
				$escortCols=$escortCols+1;
			}if($DF_TEN>0){  
				$escortCols=$escortCols+1;
			}if($DF_ABED>0){  
				$escortCols=$escortCols+1;
			}if($DF_CBED>0){  
				$escortCols=$escortCols+1;
			}
			if($DF_INF>0){  
				$escortCols=$escortCols+2;
			}
			
			
			if($addnewyes == 'no') {
				$namevalue = 'quotationId="' . $quotationId . '",fromRange="' . $paxrange . '",toRange="' . $paxrange . '",dividingFactor="' . $paxrange . '",DF_SGL="' . $DF_SGL . '",DF_DBL="' . $DF_DBL . '",DF_TWN="' . $DF_TWN . '",DF_TPL="' . $DF_TPL . '",DF_QUAD="' . $DF_QUAD . '",DF_SIX="' . $DF_SIX . '",DF_EIGHT="' . $DF_EIGHT . '",DF_TEN="' . $DF_TEN . '",DF_CBED="' . $DF_CBED . '",DF_ABED="' . $DF_ABED . '",DF_INF="' . $DF_INF . '",discount_INF="' . $discount_INF . '",addedBy="' . $_SESSION['userid'] . '",dateAdded="' . $dateAdded . '",modifyBy="' . $_SESSION['userid'] . '",modifyDate="' . $modifyDate . '",adult="'.$adult2.'",child="'.$child2.'",infant="'.$infant2.'",sglRoom="'.$sglRoom2.'",dblRoom="'.$dblRoom2.'",twinRoom="'.$twinRoom2.'",tplRoom="'.$tplRoom2.'",quadNoofRoom="'.$quadNoofRoom2.'",sixNoofBedRoom="'.$sixNoofBedRoom2.'",eightNoofBedRoom="'.$eightNoofBedRoom2.'",tenNoofBedRoom="'.$tenNoofBedRoom2.'",teenNoofRoom="'.$teenNoofRoom2.'",extraNoofBed="'.$extraNoofBed2.'",childwithNoofBed="'.$CWBed2.'",childwithoutNoofBed="'.$CNBed2.'"';
				
				$add = addlisting('totalPaxSlab', $namevalue);
				//insert foc cost and check
				}
				// else{
				// 	updatelisting('totalPaxSlab',$namevalue,'quotationId="'.$quotationId.'"');
				// }
			if($querytypeId!=13){
			$slctdSlab = '';
			$slctdSlab = GetPageRecord('fromRange,toRange', 'totalPaxSlab', '1 and quotationId="' . $quotationId . '" and status=1');
			$slctdSlabData = mysqli_fetch_array($slctdSlab);
			?>
			<div style="padding: 15px; background-color: #FFFFFF; margin: 10px 20px 0px 20px; border: 1px solid #ccc;" id="paxslab">
				<h3 id="defineslab" style="cursor:pointer;display: flex;">Define Pax Slab&nbsp;&nbsp;|&nbsp;
				<div id="selectpaxslab">
						<?php if($travelType == 2){?>Domestic<?php }else{ ?>( Min Pax: <?php echo $slctdSlabData['fromRange'] ?> | Max Pax: <?php echo $slctdSlabData['toRange'] ?> )<?php } ?></div>
				</h3>
				<table cellpadding="10" cellspacing="0" width="100%" border="0" style="border-collapse:collapse; margin-top:10px; display:none;" id="defineslabtable">
					<?php if($travelType == 1 ){?>
					<tr style="background-color: #fafafa;">
						<td align="center"></td>
						<td align="center"><a onClick="addNewRow(1);" style="color:#0000FF; cursor: pointer;">+Add&nbsp;New</a></td>
						<td align="center"><strong>Min&nbsp;Pax</strong></td>
						<td align="center"><strong>Max&nbsp;Pax</strong></td>
						<td align="center"><strong>Dividing&nbsp;Factor</strong></td>
						<td align="center"><strong>Local&nbsp;Escort</strong></td>
						<td align="center"><strong>Foreign&nbsp;Escort</strong></td>
						<td align="center"><strong>Define&nbsp;Escort&nbsp;Cost</strong></td>
						<td align="center"><strong>Action</strong></td>
					</tr>
					<?php }else{ ?>
					<tr style="background-color: #fafafa;">
						<td align="center" rowspan="2"></td>
						<td align="center" colspan="<?php echo $escortCols+1; ?>"><strong>DIVIDING FACTORS ( FOR TRANSPORT & ESCORT )</strong></td>
						<td align="center" rowspan="6"><strong>Action</strong></td>
					</tr>
					<tr style="background-color: #fafafa;">
						<td align="center"><strong>Total&nbsp;Pax</strong></td>
						<?php if($DF_SGL>0){ ?>
						<td align="center"><strong>SGL(Pax)</strong></td>
						<?php }if($DF_DBL>0){  ?>
						<td align="center"><strong>DBL(Pax)</strong></td>
						<?php }if($DF_TWN>0){  ?>
						<td align="center"><strong>TWN(Pax)</strong></td>
						<?php }if($DF_TPL>0){  ?>
						<td align="center"><strong>TPL(Pax)</strong></td>
						<?php }if($DF_QUAD>0){  ?>
						<td align="center"><strong>QUAD(Pax)</strong></td>
						<?php }if($DF_SIX>0){  ?>
						<td align="center"><strong>SIX(Pax)</strong></td>
						<?php }if($DF_EIGHT>0){  ?>
						<td align="center"><strong>EIGHT(Pax)</strong></td>
						<?php }if($DF_TEN>0){  ?>
						<td align="center"><strong>TEN(Pax)</strong></td>
						<?php }if($DF_ABED>0){  ?>
						<td align="center"><strong>BED(Adult)</strong></td>
						<?php }if($DF_CBED>0){  ?>
						<td align="center"><strong>BED(Child)</strong></td>
						<?php } if($DF_INF>0){ ?>
					
						<td align="center"><strong>Infant(Transfer/Markup)</strong></td>
						<td align="center"><strong>Infant(Discount)</strong></td>
						<?php } ?>
					</tr>
					<?php } ?>
					<tbody id="addrow"></tbody>
					<script>
						function addNewRow(id){
							if (id == 1) {
								$("#addrow").load('loadpaxslab.php?add=1&quotationId=<?php echo encode($quotationId); ?>');
							} else {
								$("#addrow").load('loadpaxslab.php?view=1&quotationId=<?php echo encode($quotationId); ?>');
							}
						}
						addNewRow(0);

						function deleteRow(id){
							var checkyes = confirm('Are you sure you want to delete?');
							if (checkyes == true) {
								$('#addrow').load('loadpaxslab.php?id=' + id + '&deletestatus=yes&quotationId=<?php echo encode($quotationId); ?>');
							}
						}

						function changeFinal(id) {
							// var checkyes = confirm('Are you sure you want to change?');
							// if (checkyes == true) {
								var checkFinal = 0;
							   	if($("#checkFinal" + id).is(':checked')){
									checkFinal = 1;
							   	}
								var fromRange = encodeURI($('#fromRange' + id).val());
								var toRange = encodeURI($('#toRange' + id).val());

								$('#selectpaxslab').text('( Min Pax: ' + fromRange + ' | Max pax: ' + toRange + ' )');
								$('#addrow').load('loadpaxslab.php?action=changeFinal&checkFinal=' + checkFinal + '&id=' + id + '&quotationId=<?php echo encode($quotationId); ?>');
							// } else {
							// 	$('#checkFinal' + id).prop("checked", false);
							// }
						}
					</script>
				</table>
			</div>
			<?php } ?>
			<script>
				$(document).ready(function() {
					$("#defineslab").click(function() {
						$("#defineslabtable").toggle();
					});
				});
			</script>

			<div id="loadhotelmaster">
				<div style="padding:20px; overflow:hidden;" id="loadnewquotationfile">Loading...
				</div>
				<script>
					function loadquotationmainfile2() {
						$('#loadnewquotationfile').load('loadnewquotationfile.php?id=<?php echo $_GET['id']; ?>&package=<?php echo $_REQUEST['package']; ?>');
					}
					loadquotationmainfile2();
				</script>

			</div>
		</td>
	</tr>
</table>
<div style="display:none;" id="changequerystatusdiv"></div>





<!--alertpopupforinbound quotation-->
<div id="inboundpopbg" style="background-image: url('images/bgpop.png'); background-repeat: repeat;">
	<div class="inboundpop">

	</div>
</div>

<style>
	#inboundpopbg {
		background-color: #00000094;
		background-color: rgba(50, 61, 76, 0.91);
		width: 100%;
		height: 100%;
		position: fixed;
		left: 0px;
		top: 0px;
		overflow: auto;
		display: none;
		z-index: 9999;

	}

	#inboundpopbg .inboundpop {
		background-color: #FFFFFF;
		max-width: 800px;
		margin: auto;
		margin-top: 20px;
		padding: 10px;
		border-radius: 5px;
	}

	#inboundpopbg .inboundheader {
	    position: relative;
	    background-color: #233a49;
	    padding: 10px;
	    color: #fff;
	    font-weight: 600;
	    border-radius: 4px;
	    font-size: 15px;
	    text-transform: uppercase;
	    overflow: hidden;
	    border-bottom: 1px solid #ddd;
	}
	#inboundpopbg .inboundheader .fa{
		position: absolute;
	    right: 15px;
	    font-size: 18px;
	    color: #ffffff;
	    cursor: pointer;
	}

	#inboundpopbg .inboundbody {
		position: relative;
		padding: 10px;
		overflow: auto;
   	 	text-align: left;
		color: #000;
	}

	#inboundpopbg .inboundfooter {
		position: relative;
	    padding: 10px;
	    color: #000;
	    font-weight: 400;
	    cursor: pointer;
	    font-size: 13px;
	    overflow: hidden;
	    border-top: 1px solid #ddd;
	        padding-bottom: 0px!important;
	}
	.markupdiv{
		display: grid;grid-template-columns: auto;grid-gap: 5px;
	}
	.x_markupType{
		padding: 6px 10px;max-width: 70px;background-color: #fff;border-radius: 2px;margin: auto;
	} 
	.markInput {
   	 	padding: 5px 10px;
	    max-width: 42px;
	    background-color: #ffffff;
	    border: 1px solid #ccc;
	    border-radius: 2px;
	    text-align: center;
	    margin: auto;
	}
	.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
		width: 100% !important;
	}

	#inboundpopbg .inboundpop {
		max-width: 1200px !important;
		margin-top: 60px !important;
	}

	.contentbox table tr td div {
		font-size: 12px;
	}

	.contentbox {
		padding: 10px;
	}
</style>

<script>
	function openinboundpop(url, popwidth) {
		$('#inboundpopbg').show();
		var url = encodeURI(url);
		$('.inboundpop').load('inboundpop.php?' + url);
		$('.inboundpop').css('width', popwidth);
	}

	function closeinbound() {
		$('#inboundpopbg').hide();
		$('.inboundpop').html('');
	}
</script>