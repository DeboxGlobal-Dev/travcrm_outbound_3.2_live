<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
  
if($_GET['id']!=''){
 


$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=decode($_GET['id']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);   

?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
 <script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    tinymce.init({

        selector: "#description",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>

<style>
body{background-color:#eae9ee !IMPORTANT;}
.style1 {font-weight: bold}
</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>

<!-- ====================Checklist slider same as quotation Page================================= -->
<?php if ($resultpage['moduleType'] == '1') { ?>
				<td width="10%" align="left" valign="top" class="queryleft">
					<div class="innerdiv">

						<div class="contentbox" style="background-color: rgba(0,0,0,0.2);">
							<div class="lables">
								<?php echo date('j F Y', $resultpage['dateAdded']); ?> &nbsp;<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('h:i A', $resultpage['dateAdded']); ?> <?php if ($resultpage['queryPriority'] == 2) { ?><div class="mediampire" style="float: right;padding: 5px 5px;top: 4px;">Medium</div><?php } ?><?php if ($resultpage['queryPriority'] == 3) { ?><div class="highpire" style="float: right;padding: 5px 5px;">High</div><?php } ?></div>
							<div style="font-size:24px;" class="statustbs">
								<div style="font-size:16px!important;padding:0!important;left: 15px!important;" class="statustbs">Query Id</div><br><?php echo makeQueryId($resultpage['id']); ?>
							</div>
							<?php if ($resultpage['queryStatus'] == 3) { ?><div style="font-size:16px;" class="statustbs">Tour Id - <?php echo makeQueryTourId($resultpage['id']); ?></div>
								<div style="font-size:16px;" class="statustbs">Reference No - <?php echo ($resultpage['referanceNumber']); ?> </div><?php } ?>
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
										<div style="margin-bottom:2px; font-size:12px;"><?php echo showClientTypeUserName($resultpage['clientType'], $resultpage['companyId']); ?></div>
										<div style="margin-bottom:2px; font-size:12px;"><?php echo $resultpage['guest1phone']; ?></div>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="left" valign="top">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" align="left" valign="top"><?php if ($getphone != '') { ?>
											<div style="margin-bottom:2px; font-size:12px;"><a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=&source=&data=" target="_blank"><img src="images/whatsapp-button.png" width="107" border="0" /></a></div>
										<?php } ?>
									</td>
								</tr>
							</table>
						</div>
						<div class="contentbox" style="padding:5px; background-color:#232a32;">

							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td colspan="2">
										<div class="lables">From</div> <?php
																		$myArray = explode(',', $resultpage['fromdestinationId']);
																		foreach ($myArray as $my_Array) {
																			if ($my_Array != '') {
																				$select4 = 'name';
																				$where4 = 'id=' . $my_Array . '';
																				$rs4 = GetPageRecord($select4, _DESTINATION_MASTER_, $where4);
																				$cityname = mysqli_fetch_array($rs4);
																				$cityNameVal .= $cityname['name'] . ', ';
																			}
																		}
																		echo rtrim($cityNameVal, ', '); ?>
									</td>
									<td align="center">
										<div class="lables">
											&nbsp;</div><i class="fa fa-long-arrow-right" aria-hidden="true" style="    color: #ffffff94;
											font-size: 18px;"></i>
									</td>
									<td align="right">
										<div class="lables">
											To </div>
										<?php
										if ($resultpage['destinationId'] != '' && $resultpage['destinationId'] != '0') {
											$myArray = explode(',', $resultpage['destinationId']);
											foreach ($myArray as $my_Array) {
												if ($my_Array != '') {
													$tode = $my_Array;
												}
											}
											if ($tode != '') {
												$select4 = 'name';
												$where4 = 'id="' . $tode . '"';
												$rs4 = GetPageRecord($select4, _DESTINATION_MASTER_, $where4);
												$cityname = mysqli_fetch_array($rs4);
												echo $cityname['name'];
											}
										}
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
									<?php if ($resultpage['dayWise'] != 2) { ?><td width="31%" align="left" valign="top" class="he">Date</td><?php } ?>
								</tr>
								<?php
								$n = 1;

								$rs1 = "";
								$rs1 = GetPageRecord('*', 'packageQueryDays', 'queryId="' . $resultpage['id'] . '" order by srdate asc');
								while ($packageQueryData = mysqli_fetch_array($rs1)) {
									
								?>
									<tr>
										<td align="center" valign="top">Day&nbsp;<?php echo $n; ?></td>
										<td align="left" valign="top"><?php echo getDestination($packageQueryData['cityId']); ?></td>
										<?php if ($resultpage['dayWise'] != 2) { ?> <td align="left" valign="top"><?php echo date('d-m-Y', strtotime($packageQueryData['srdate'])); ?></td><?php } ?>
									</tr>
								<?php $n++;
								}  ?>
							</table>
						</div>

						<div class="contentbox" style="padding:0px;">
							<table width="100%" border="0" cellpadding="2" cellspacing="0">


								<tr>
									<td align="center">
										<div style="background-color:#232a32; margin-right:2px; padding:4px;">
											<div class="lables">Nights</div><?php echo $resultpage['night']; ?>
										</div>
									</td>
									<td align="center">
										<div style="background-color:#232a32; margin-right:2px; padding:4px;">
											<div class="lables">Adult</div><?php echo $resultpage['adult']; ?>
											<input type="hidden" id="adult" name="adult" value="<?php echo $resultpage['adult']; ?>" />
										</div>
									</td>
									<td align="center">
										<div style="background-color:#232a32; margin-right:2px;padding:4px;">
											<div class="lables">Child</div><?php echo $resultpage['child']; ?> <input type="hidden" id="child" name="child" value="<?php echo $resultpage['child']; ?>" />
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
						<hr />

						<div class="contentbox" style="padding:0px;">
							<table width="100%" border="0" cellpadding="2" cellspacing="0">
								<tr>
									<td width="33%" align="center">
										<div style="background-color:#232a32; margin-right:2px; padding:4px;">
											<div class="lables">SGL</div><?php echo $resultpage['sglRoom']; ?>
										</div>
									</td>
									<td width="33%" align="center">
										<div style="background-color:#232a32; margin-right:2px; padding:4px;">
											<div class="lables">DBL</div><?php echo $resultpage['dblRoom']; ?>
										</div>
									</td>
									<td width="33%" align="center">
										<div style="background-color:#232a32; margin-right:2px; padding:4px;">
											<div class="lables">TPL</div><?php echo $resultpage['tplRoom']; ?>
										</div>
									</td>
								</tr>
								<tr>
									<td align="center">
										<div style="background-color:#232a32; margin-right:2px; padding:4px;">
											<div class="lables">TWIN</div><?php echo $resultpage['twinRoom']; ?>
										</div>
									</td>
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

									<td align="center">
										<div style="background-color:#232a32; margin-right:2px;padding:4px;">
											<div class="lables">&nbsp;</div>
										</div>
									</td>
								</tr>
							</table>
						</div>

						<div class="contentbox">
							<div class="lables">Room Preference</div>
							<?php echo $resultpage['twin']; ?>
						</div>

						<div class="contentbox" style="padding:0px;"></div>
						<?php if ($resultpage['clientType'] == 222) { ?>

							<div class="contentbox">

								<div class="lables">Meal Preference</div> <?php
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
							<div class="contentbox">
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
							<div class="contentbox">
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

<!-- ===================================================== -->

   
	  

    <td width="100%" align="left" valign="top" class="queryright">
	
	 <div class="contentboxaddagent">
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="changestatusquery" target="actoinfrm" id="changestatusquery">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td><div class="headingm" style="margin-left:20px;"><table border="0" cellpadding="0" cellspacing="0">
  <tbody>
    
    <tr>
    <td><strong>Check List</strong> - <?php echo strip($resultpage['subject']); ?></td>
  </tr>
</tbody></table>
</div> </td>
    </tr>
</tbody></table>
</form>
</div>	

<div id="loadchecklist"><div style="padding:20px; text-align:center;">Loading...</div></div>
<script>
function loadchecklistfun(){
$('#loadchecklist').load('loadchecklist.php?id=<?php echo decode($_GET['id']); ?>');
}

function deltloadchecklistfun(id){
$('#loadchecklist').load('loadchecklist.php?id=<?php echo decode($_GET['id']); ?>&dltid='+id);
}

function editloadchecklistfun(id){
$('#loadchecklist').load('loadchecklist.php?id=<?php echo decode($_GET['id']); ?>&editid='+id);
}

function editstatusloadchecklistfun(id,status){
$('#loadchecklist').load('loadchecklist.php?id=<?php echo decode($_GET['id']); ?>&editidstaus='+id+'&status='+status);
masters_alertspopupopenClose();
}
loadchecklistfun()
</script>
</td>
  </tr>
</table>

<div style="display:none;" id="changequerystatusdiv"></div>

 
<?php } ?>