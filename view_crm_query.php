<?php
$loadqueryyes = 1;
if ($viewpermission != 1 && $_GET['id'] != '') {
	header('location:' . $fullurl . '');
}
?>
<script>
	function getbody(mailId) {
		$('#querymailbody' + mailId).html('<div style="text-align:center; width:100%;"><img src="images/loadinggare.svg" ><br><br>Loading....</div>');
		$('#querymailbody' + mailId).load('querymailbody.php?mailId=' + mailId);
	}
</script>
<?php
include "config/mail.php";
function strip_html_tags($text)
{
	$text = preg_replace(
		array(
			// Remove invisible content
	'@<head[^><meta http-equiv="Content-Type" content="text/html; charset=utf-8">]*?>.*?</head>@siu',
	'@<style[^>]*?>.*?</style>@siu',
	'@<script[^>]*?.*?</script>@siu',
	'@<object[^>]*?.*?</object>@siu',
	'@<embed[^>]*?.*?</embed>@siu',
	'@<applet[^>]*?.*?</applet>@siu',
	'@<noframes[^>]*?.*?</noframes>@siu',
	'@<noscript[^>]*?.*?</noscript>@siu',
	'@<noembed[^>]*?.*?</noembed>@siu',
	// Add line breaks before and after blocks
	'@</?((address)|(blockquote)|(center)|(del))@iu',
	'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
	'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
	'@</?((table)|(th)|(td)|(caption))@iu',
	'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
	'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
	'@</?((frameset)|(frame)|(iframe))@iu',
),
array(
' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
"\n\$0", "\n\$0",
),
$text
);
return strip_tags(str_replace('Content-Type: text/plain; charset="UTF-8"', '', $text));
}

// different function for this
if ($_REQUEST['deletestatusDuplicate'] == 1 && $_REQUEST['quotationId'] > 0) {
	$sql_del = "delete from quotationMaster where id='" . $_REQUEST['quotationId'] . "'";
	mysqli_query(db(), $sql_del) or die(mysqli_error(db()));
	$sql_del = "delete from newQuotationDays where quotationId='" . $_REQUEST['quotationId'] . "'";
	mysqli_query(db(), $sql_del) or die(mysqli_error(db()));
	header('location:showpage.crm?module=query&view=yes&id=' . $_GET['id'] . '&b2bquotation=1');
}
// delete all deletestatus is yes quotations
$sql_del = "delete from quotationMaster where deletestatus=1 ";
mysqli_query(db(), $sql_del) or die(mysqli_error(db()));

if ($_GET['id'] != '') {
	
	$select = '';
	$where = '';
	$rs = '';
	$id = clean(decode($_GET['id']));
	$rs = GetPageRecord('*',_QUERY_MASTER_,'id="'.$id.'"');
	$resultpage = mysqli_fetch_array($rs);
	$queryTypeId = $resultpage['queryType'];
	$isTourEx = 0;
	if ($_REQUEST['tourextension'] == 1) {
		$isTourEx = 1;
	}

	$rsq1 = '';
	$rsq1 = GetPageRecord('*',_QUOTATION_MASTER_, 'queryId="'.$resultpage['id'].'" and status=1 and isTourEx="'.$isTourEx.'"');
	$resultpageQuotation = mysqli_fetch_array($rsq1);

	if($resultpageQuotation['id'] == 0) {
		$quotationDataq = '0';
	} else {
		$quotationDataq = trim($resultpageQuotation['id']);
	}

	$rsp = GetPageRecord('*',_PAYMENT_REQUEST_MASTER_,'queryid="'.$resultpage['id'].'" and quotationId="'.$resultpageQuotation['id'].'"');
	$resultpaymentpage = mysqli_fetch_array($rsp);
	$totalClientCost = $resultpaymentpage['totalClientCost'];
	$quotationId = $resultpaymentpage['quotationId'];

	$rspaid = GetPageRecord('sum(amount) as paidAmount','agentPaymentMaster','paymentId="'.$resultpaymentpage['id'].'" and quotationId="'.$resultpaymentpage['quotationId'].'"');
	$paidAMTData = mysqli_fetch_assoc($rspaid);
	$paidAmount = $paidAMTData['paidAmount'];

	$clientPedingAMT = $totalClientCost-$paidAmount;

	$select = '';
	$where = '';
	$rs = '';
	$select = 'email';
	$where = 'id=' . $resultpage['assignTo'] . '';
	$rs = GetPageRecord($select, _USER_MASTER_, $where);
	$resultpageassignemail = mysqli_fetch_array($rs);
	$select = '';
	$where = '';
	$rs = '';
	$select = '*';
	$where = 'id=1';
	$rs = GetPageRecord($select, _QUERY_MAILS_SECTION_MASTER_, $where);
	$resultpageemail = mysqli_fetch_array($rs);
	if ($resultpage['clientType'] == 2) {
		$select2 = '*';
		$where2 = 'id=' . $resultpage['companyId'] . '';
		$rs2 = GetPageRecord($select2, _CONTACT_MASTER_, $where2);
		$contantnamemain = mysqli_fetch_array($rs2);
		$clientnemdisplay = $contantnamemain['firstName'] . ' ' . $contantnamemain['lastName'];
		$clientnem = $contantnamemain['firstName'] . ' ' . $contantnamemain['lastName'];
		$getphone =  getPrimaryPhone($resultpage['companyId'], 'contacts');
		$getemail =  getPrimaryEmail($resultpage['companyId'], 'contacts');
		if($contantnamemain['contactType'] == 1){
			$gradeId = $contantnamemain['gradeId'];
		}
	}
	if ($resultpage['clientType'] == 1) {
		$select2 = '*';
		$where2 = 'id=' . $resultpage['companyId'] . '';
		$rs2 = GetPageRecord($select2, _CORPORATE_MASTER_, $where2);
		$contantnamemain = mysqli_fetch_array($rs2);
		$clientnemdisplay = $contantnamemain['contactPerson'];
		//$clientnem = getCorporateCompany($editcompanyId);
		$getemail = getPrimaryEmailCompany($resultpage['companyId'], "corporate");
		$getphone = getPrimaryPhone($resultpage['companyId'], "corporate");

	}


	$rscontryCode=GetPageRecord('*','companySettingsMaster','id=1');
	$GetcontryCode = mysqli_fetch_array($rscontryCode);
	$compContryCode = $GetcontryCode['compcountryCode'];



	?>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="css/main.css" rel="stylesheet" type="text/css" />
	<script src="tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "#description",
			themes: "modern",
			relative_urls: false,
			remove_script_host: false,
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
		tinymce.init({
			selector: "#descriptionPdf",
			themes: "modern",
			relative_urls: false,
			remove_script_host: false,
			plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
	</script>
	<style>
	#rightquerylink a {
		padding: 10px 0px;
		display: block;
		color: #333333;
		border-bottom: 1px #e6e6e6 solid;
		font-size: 14px;
		position: relative;
		padding-left: 32px;
	}
	#rightquerylink a .fa {
		color: #2c2c2c;
		font-size: 17px;
		position: absolute;
		left: 8px;
		top: 10px;
	}
	#rightquerylink .fagreen .fa {
		color: #82b767 !important;
	}
	#rightquerylink a:hover {
		background-color: #F5F5F5;
	}
	.mailread {
		width: 8px;
		height: 8px;
		background-color: #009900;
		font-size: 0px;
		position: absolute;
		left: -17px;
		border-radius: 50px;
		top: 3px;
	}
	.nomailread {
		width: 8px;
		height: 8px;
		background-color: #ff7615;
		font-size: 0px;
		position: absolute;
		left: -17px;
		border-radius: 50px;
		top: 3px;
	}
	.querymaillisting .maintitle {
		width: 80% !important;
	}
	.querymiddlebox {
		width: 60% !important;
	}
	body {
		background-color: #eae9ee !IMPORTANT;
	}
	.statustbs div {
		font-size: 11px !important;
		width: auto !important;
		min-width: auto !important;
		padding: 4px 8px !important;
		position: absolute !important;
		left: 160px !important;
		top: 82px !important;
	}
	.statustbs2 div {
		font-size: 11px !important;
		width: auto !important;
		min-width: auto !important;
		padding: 2px 4px !important;
		position: absolute !important;
		left: 90px !important;
		top: -4px !important;
	}
	</style>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<?php if ($resultpage['moduleType'] == '1') { ?>
	<td width="10%" align="left" valign="top" class="queryleft">
		<div class="innerdiv">
			<div class="contentbox" style="background-color: rgba(0,0,0,0.2);">
				<div class="lables">
					<?php echo date('j F Y', $resultpage['dateAdded']); ?> &nbsp;<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('h:i A', $resultpage['dateAdded']); ?> <?php if ($resultpage['queryPriority'] == 2) { ?><div class="mediampire" style="float: right;padding: 5px 5px;top: 4px;">Medium</div><?php } ?><?php if ($resultpage['queryPriority'] == 3) { ?><div class="highpire" style="float: right;padding: 5px 5px;">High</div><?php } ?></div>
					<div style="font-size:24px;" class="statustbs">
						<div style="font-size:16px!important;padding:0!important;left: 15px!important;" class="statustbs">Query Id</div><br><?php echo makeQueryId($resultpage['id']); ?>
					</div>
					<?php if (($resultpage['queryStatus'] == 3 && $resultpage['queryConfirmingDate']!='NULL') || ($resultpage['queryStatus'] == 20 && $resultpage['queryConfirmingDate']!='NULL')) { ?>
						<div style="font-size:16px;" class="statustbs">Tour Id - <?php echo makeQueryTourId($resultpage['id']); ?></div>
						<div style="font-size:16px;" class="statustbs">Reference No - <?php echo ($resultpage['referanceNumber']); ?></div>
					<?php } ?>
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
								<div style="margin-bottom:2px; font-size:12px;"><?php echo ucfirst(showClientTypeUserName($resultpage['clientType'], $resultpage['companyId'])); ?></div>
								<div style="margin-bottom:2px; font-size:12px;">
								
								<!-- <?php echo $resultpage['guest1phone']; ?> -->
								<?php
								if($resultpage['contryCode']!=''){
									$cntcode = "+";
								}
							?>
							<!-- +91 code -->
							<div style="margin-bottom:2px; font-size:12px;">
							<?php echo $cntcode.$resultpage['contryCode'].' '.$resultpage['guest1phone']; ?>
							</div>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="left" valign="top">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" align="left" valign="top"><?php if ($getphone != '') { ?>
								<div style="margin-bottom:2px; font-size:12px;"><a href="https://api.whatsapp.com/send?phone=<?php echo $compContryCode.''.$getphone; ?>&text=&source=&data=" target="_blank"><img src="images/whatsapp-button.png" width="107" border="0" /></a></div>
								<?php } ?>
							</td>
						</tr>
					<?php 
					if($gradeId>0 ){
						$packageQuery1 = GetPageRecord('*', 'packageQueryDays', 'queryId="' . $resultpage['id'] . '" order by id asc limit 1');
						$packageD = mysqli_fetch_array($packageQuery1);

						$cityQuery = GetPageRecord('*', 'destinationMaster', ' id="' . $packageD['cityId'] . '" ');
						$cityD = mysqli_fetch_array($cityQuery);
						$cityD['gradeId'];
						if($cityD['gradeId']!=''){
							$gradeQuery=GetPageRecord('*','gradeMaster',' 1 and id="'.$gradeId.'"'); 
							$gradeD=mysqli_fetch_assoc($gradeQuery); 
							$gradeName = '<strong style="font-size:14px;">'.$cityD['name'].' | '.ucfirst($cityD['gradeId']).' ('.$gradeD[$cityD['gradeId']].')</strong>';
							?>
							<tr>
								<td colspan="2" align="left" valign="top">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="left" valign="top">
									<div style="margin-bottom:2px; font-size:12px;"><?php echo $gradeName; ?></div>
								</td>
							</tr>
							<?php 
						} 
					} ?>
					</table>
				</div>
				<?php if($queryTypeId!=13){ ?>
				<div class="contentbox" style="padding:5px; background-color:#232a32;">
				
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="2">
								<div class="lables">Start.&nbsp;City</div><?php

							if($resultpage['fromWB']!=""){
								echo $resultpage['fromWB'];
							}else{
								$sp1 = GetPageRecord('*', 'packageQueryDays', 'queryId="' . $resultpage['id'] . '" order by srdate asc');
								$startingPointD = mysqli_fetch_array($sp1);
								echo getDestination($startingPointD['cityId']);
							}
							?></td>
							<td align="center">
								<div class="lables">Nights</div><?php echo $resultpage['night']; ?>
							</td>

							<td align="right">
								<div class="lables">End&nbsp;City</div>
								<?php
								$sp1 = GetPageRecord('*', 'packageQueryDays', 'queryId="' . $resultpage['id'] . '" order by srdate desc');
								$startingPointD = mysqli_fetch_array($sp1);
								echo getDestination($startingPointD['cityId']);
							?></td>
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
							//resListing
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
				<?php } ?>
				<div class="contentbox" style="padding:0px;">
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Adult</div><?php echo $resultpage['adult']; ?>
									<!-- <input type="hidden" id="adult" name="adult" value="<?php echo $resultpage['adult']; ?>" /> -->
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Child</div><?php echo $resultpage['child']; ?>
									<!-- <input type="hidden" id="child" name="child" value="<?php echo $resultpage['child']; ?>" /> -->
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px;padding:4px;">
									<div class="lables">Infant</div><?php echo $resultpage['infant']; ?> 
									<!-- <input type="hidden" id="infant" name="infant" value="<?php echo $resultpage['infant']; ?>" /> -->
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
				<?php 

					$roomrs = GetPageRecord('*','roomMaster','roomName="quadroom"');
					$roomQuad = mysqli_fetch_assoc($roomrs);

					$roomrs1 = GetPageRecord('*','roomMaster','roomName="sixbedroom"');
					$roomSix = mysqli_fetch_assoc($roomrs1);

					$roomrs2 = GetPageRecord('*','roomMaster','roomName="eightbedroom"');
					$roomEight = mysqli_fetch_assoc($roomrs2);

					$roomrs3 = GetPageRecord('*','roomMaster','roomName="tenbedroom"');
					$roomTen = mysqli_fetch_assoc($roomrs3);

					$roomrs4 = GetPageRecord('*','roomMaster','roomName="teenbed"');
					$roomTeen = mysqli_fetch_assoc($roomrs4);

					?>
				<div class="contentbox" style="padding:0px;">
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="33%" align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">SGL</div><?php echo $resultpage['sglRoom']; ?>
								</div>
							</td>
							<td width="33%" colspan="2" align="center">
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
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">CWB</div><?php echo $resultpage['cwbRoom']; ?>
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">CNB</div><?php echo $resultpage['cnbRoom']; ?>
								</div>
							</td>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">E.Bed</div><?php echo $resultpage['extraNoofBed']; ?>
								</div>
							</td>
						</tr>

						<tr>
							<?php if($roomTeen['status']==1){ ?>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Teen BR</div><?php echo $resultpage['teenNoofRoom']; ?>
								</div>
							</td>
							<?php } if($roomQuad['status']==1){ ?>
							<td align="center" colspan="2">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Quad BR</div><?php echo $resultpage['quadNoofRoom']; ?>
								</div>
							</td>
							<?php } if($roomSix['status']==1){ ?>
							<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Six BR</div><?php echo $resultpage['sixNoofBedRoom']; ?>
								</div>
							</td>
							<?php } ?>
						</tr>
						<tr>
						<?php if($roomEight['status']==1){ ?>
						<td align="center">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Eight BR</div><?php echo $resultpage['eightNoofBedRoom']; ?>
								</div>
							</td>
							<?php } if($roomTen['status']==1){ ?>
							<td align="center" colspan="2">
								<div style="background-color:#232a32; margin-right:2px; padding:4px;">
									<div class="lables">Ten BR</div><?php echo $resultpage['tenNoofBedRoom']; ?>
								</div>
							</td>
							<?php } ?>
						</tr>
					</table>
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
							<td align="center">
								<?php 
							$rs='';
							$rs=GetPageRecord('*','tbl_languagemaster','id="'.$resultpage['preferredLang'].'"');
							$resListing=mysqli_fetch_array($rs);

							$language11 = $resListing['name'];

							?>

							<!-- <div class="lables"> Language</div> -->
								<div style="background-color:#232a32; margin-right:2px;padding:4px;">
								<div class="lables">  Preferred Language</div>
									<div class="lables">&nbsp;<?php echo  $language11;?></div>
								</div>
							</td>
						</tr>
					</table>
				</div>
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
					<div class="lables">Meal Preference</div><?php
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
				
				<?php
				if(clean($resultpage['additionalInfo'])!=''){
					$queryDescription = clean($resultpage['additionalInfo']);
				}else{
					$queryDescription = clean(strip_tags($resultpage['description']));
				}

				if($queryDescription!=''){
					?>
					<div class="contentbox">
						<div class="lables">Additional Info</div>
						<?php echo $queryDescription; ?>
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<td width="60%" align="left" valign="top" class="querymiddlebox">
			<div class="heading" style="position:relative;">
				<table border="0" cellpadding="0" cellspacing="0" style="position:absolute; right:10px; top:67px;">
					<tr>
					<td><?php if ($_REQUEST['notes'] != 1 && $_REQUEST['supplier'] != 1 && $_REQUEST['quotations'] != 1 && $_REQUEST['b2bquotation'] != 1 && $resultpage['moduleType'] != 2  && $_REQUEST['tourextension'] != 1 && $resultpage['moduleType'] != 3 && $resultpage['moduleType'] != 4) { ?><input style="margin-right: 10px;" type="button" name="Submit3" value="Reply" class="rediingmbutton submitbtn" id="replybtn" onClick="$('#replymainbox').show();$('#replybtn').hide();emailloadotherItinerary();" /><?php } ?></td>
					<style>
						.getmail {
							padding: 8px;
							border: 1px solid;
							border-radius: 23px;
							background-color: #ebde41;
							color: #fff;
							margin-right: 5px;
							width: 100px;    
							font-size: 13px !important;
						}
					</style>
					<?php if ($_REQUEST['notes'] == 1) { ?><td><input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="Add Note" style="margin-right:10px;" onClick="alertspopupopen('action=addNotes&queryId=<?php echo $resultpage['id']; ?>','450px','auto');" /></td><?php } ?>
					<?php if ($resultpage['moduleType'] == '1') { ?>
					<?php if ($_REQUEST['notes'] != 1) { ?><td>
						<div class="getmail" id="getMailButton" onClick="loadMail();"><i class="fa fa-get-pocket" aria-hidden="true"></i>&nbsp;Send/Receive</div>
					</td><?php }
					} ?>
					<?php if ($_REQUEST['supplier'] == 1 && !isset($_REQUEST['supplierId'])) { ?><td><input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="Add Supplier" style="margin-right:10px;" onClick="alertspopupopen('action=addsupplierquote&queryId=<?php echo $resultpage['id']; ?>','450px','auto');" /></td><?php } ?>
					<div id="mailload"></div>
					<script>
						function loadMail() {
							window.location.href="cron_run.php";
							// $('#mailload').load('cron_run.php?module=query&view=yes&id=<?php echo encode($id); ?>&supplier=<?php echo $_REQUEST['supplier'] ?>');
							$('#getMailButton').hide();
							$('#waitingButton').show();
							// location.reload();
						}
					</script>
					<?php if ($_REQUEST['quotations'] == 1) { ?><td><a href="showpage.crm?module=packagebuilder&add=yes&type=2&queryid=<?php echo $resultpage['id']; ?>"><input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="<?php if ($resultpage['moduleType'] == '1') { ?>Add&nbsp;Quotation<?php } ?>" style="margin-right:10px;" /></a></td><?php } ?>
					<?php if ($_REQUEST['tourextension'] == 1) { ?><td><a onClick="alertspopupopen('action=addTourExtension&queryId=<?php echo encode($resultpage['id']); ?>&quotationId=<?php echo ($_GET['id']); ?>','700px','auto');"><input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="<?php if ($resultpage['moduleType'] == '1') { ?>Add&nbsp;Tour&nbsp;Extension<?php } ?>" style="margin-right:10px;" /></a></td><?php } ?>
					<?php
					$result = mysqli_query(db(), "select * from " . _QUOTATION_MASTER_ . " where queryId='" . $resultpage['id'] . "'")  or die(mysqli_error(db()));
					$number = mysqli_num_rows($result);
					// check if main series exist
					$checkMainSeriesSql = '';
					$checkMainSeriesSql = GetPageRecord("*", _QUOTATION_MASTER_, " queryId='" . $resultpage['id'] . "' and isSeries=0 ");
					$IsCheckMainSeries = mysqli_num_rows($checkMainSeriesSql);
					if ($_REQUEST['b2bquotation'] == 1 || ($resultpage['moduleType'] == 2 && $IsCheckMainSeries == 0) || $resultpage['moduleType'] == 3 || ($resultpage['moduleType'] == 4 && $number < 1)) { ?>
					<td>
						<input name="addnewuserbtn22" type="button" class="greenbuttonx2 green" id="addnewuserbtn22" value="<?php if ($resultpage['moduleType'] == '1') { ?>Add Quotation
						<?php }
						if ($resultpage['moduleType'] == '2') { ?>Add Series
						<?php }
						if ($resultpage['moduleType'] == '3') { ?>Add&nbsp;Fix&nbsp;Departure
						<?php }
						if ($resultpage['moduleType'] == '4') { $modulesurl ='&package=yes' ?>Add&nbsp;Package
						<?php } ?>" style="max-width: 130px; height:31px;padding:5px 10px;" onClick="alertspopupopen('action=selectItineraryType&queryId=<?php echo $resultpage['id']; ?>&qtype=<?php echo $queryTypeId; ?>&moduleType=<?php echo $resultpage['moduleType'].$modulesurl; ?>','800px','auto');" />
					</td>
					
					<?php } ?>
					<td><a href="<?php echo $fullurl; ?>showpage.crm?module=<?php if ($resultpage['moduleType'] == '1') { ?>query<?php }
						if ($resultpage['moduleType'] == '2') { ?>series<?php }
						if ($resultpage['moduleType'] == '3') { ?>fixdeparture<?php }
						if ($resultpage['moduleType'] == '4') { ?>package<?php } ?>">
						<input type="button" name="Submit22" value="Back" class="whitembutton" /></td>
					</tr>
				</table>
				<table width="100" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<div>
								<div style="font-size:12px; color:#CCC; position:relative;" class="statustbs2">
									<?php if ($resultpage['moduleType'] == 1) { ?> SUBJECT <?php } ?>
									<?php if ($resultpage['moduleType'] == 2) { ?> SERIES <?php } ?>
									<?php if ($resultpage['moduleType'] == 3) { ?> Fixed&nbsp;Departure <?php } ?>
									<?php if ($resultpage['moduleType'] == 4) { ?> Package<?php } ?>
									<?php if ($resultpage['queryStatus'] == 1) {
										echo '<div class="assignquery">Assigned</div>';
										$list_id = '4e463bf6b0';
									}
									if ($resultpage['queryStatus'] == 10) {
										echo '<div class="assignquery">Created</div>';
										$list_id = 'def158a3e6';
									}
									if ($resultpage['queryStatus'] == 6) {
										echo '<div class="assignquery">Quote&nbsp;Sent</div>';
										$list_id = 'b09914105b';
									}
									if ($resultpage['queryStatus'] == 7) {
										echo '<div class="assignquery">Follow-up</div>';
										$list_id = '89a790fe49';
									}
									if ($resultpage['queryStatus'] == 2) {
										echo '<div class="revertquery">Reverted</div>';
										$list_id = '3038454095';
									}
									if ($resultpage['queryStatus'] == 3) {
										echo '<div class="wonquery">Confirmed</div>';
										$list_id = '6b195b2b00';
									}
									if ($resultpage['queryStatus'] == 4) {
										echo '<div class="lossquery">Lost</div>';
										$list_id = '2f513eb084';
									}
									if ($resultpage['queryStatus'] == 5) {
										echo '<div class="closequery">Quotation Generated</div>';
										$list_id = '7ca430f7f0';
									}
									if ($resultpage['queryStatus'] == 0) {
										echo '<div class="assignquery">Assigned</div>';
										$list_id = '4e463bf6b0';
								} ?></div>
								<div style="font-size:18PX; text-overflow: ellipsis;white-space: nowrap;  overflow: hidden; "><?php echo strip($resultpage['subject']); ?><?php if ($_REQUEST['notes'] != 1) { ?><div class="getmail" id="waitingButton" style="display:none; width: 300px !important; float: right; margin-left: 241px;"><i class="fa fa-spinner fa-spin" style="font-size:24px;"></i>&nbsp;&nbsp;Fetching mail Please wait...</div><?php } ?></div>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div style="overflow:hidden; border-bottom:2px #ffc115 solid; height:43px;<?php if ($resultpage['moduleType']=='4') { ?>display: none;<?php } ?>">

			<?php if ($resultpage['quotationYes'] == 1 && $resultpage['moduleType'] == '1') { ?>
				<a href="showpage.crm?module=query&amp;view=yes&amp;id=<?php echo $_REQUEST['id']; ?>&quotations=1" style="padding:10px 20px; float:left; font-size:15px; <?php if ($_REQUEST['quotations'] == 1) { ?>background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;<?php } else { ?>background-color:#fff; color:#000;   border:1px solid #fff;<?php } ?>"><strong>Quotation</strong></a>
				<?php } ?>


				<?php if ($resultpage['quotationYes'] == 1 && $resultpage['moduleType'] == '2') { ?>
				<a href="" style="padding:10px 20px; float:left; font-size:15px;background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;"><strong>Series&nbsp;Costing</strong></a>
				<?php } ?>

				<?php if ($resultpage['quotationYes'] == 2 && $resultpage['moduleType'] == '1') { ?>
				<a href="showpage.crm?module=query&amp;view=yes&amp;id=<?php echo $_REQUEST['id']; ?>&b2bquotation=1" style="padding:10px 20px; float:left; font-size:15px; <?php if ($_REQUEST['b2bquotation'] == 1) { ?>background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;<?php } else { ?>background-color:#fff; color:#000;   border:1px solid #fff;<?php } ?>"><strong>Quotation</strong></a>
				<?php } ?>

				<?php if ($resultpage['quotationYes'] == 2 && $resultpage['moduleType'] == '2') { ?>
				<a href="" style="padding:10px 20px; float:left; font-size:15px;background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;"><strong>Series&nbsp;Costing</strong></a>
				<?php } ?>
				<?php if ($resultpage['moduleType'] == '1') { ?>
				<a href="showpage.crm?module=query&amp;view=yes&amp;id=<?php echo $_REQUEST['id']; ?>&tourextension=1" style="padding:10px 20px; float:left; font-size:15px; <?php if ($_REQUEST['tourextension'] == 1) { ?>background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;<?php } else { ?>background-color:#fff; color:#000; border:1px solid #fff;<?php } ?>"><strong>Tour Extension</strong></a>
				<?php } ?>



				<?php if ($resultpage['moduleType'] == '1') { ?>
				<a href="showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['id']; ?>" style="padding:10px 20px; float:left;  font-size:15px; <?php if ($_REQUEST['notes'] != 1 && $_REQUEST['supplier'] != 1 && $_REQUEST['quotations'] != 1 && $_REQUEST['b2bquotation'] != 1 && $_REQUEST['feedback'] != 1 && $_REQUEST['tourextension'] != 1) { ?>background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;<?php } else { ?>background-color:#fff; color:#000;   border:1px solid #fff;<?php } ?>"><strong>Client Communication </strong></a>
				<?php } ?>
				
				<!--<a href="showpage.crm?module=query&amp;view=yes&amp;id=<?php echo $_REQUEST['id']; ?>&notes=1" style="padding:10px 20px; float:left; font-size:15px; <?php if ($_REQUEST['notes'] == 1) { ?>background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;<?php } else { ?>background-color:#fff; color:#000; margin-left:5px;  border:1px solid #fff;<?php } ?>"><strong>Notes</strong></a>-->
				
				
				<?php if ($resultpage['moduleType'] == '1') { ?>
				<a href="showpage.crm?module=query&amp;view=yes&amp;id=<?php echo $_REQUEST['id']; ?>&supplier=1" style="padding:10px 20px; float:left; font-size:15px; <?php if ($_REQUEST['supplier'] == 1) { ?>background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;<?php } else { ?>background-color:#fff; color:#000;   border:1px solid #fff;<?php } ?>"><strong>Supplier Communication</strong></a>
				<?php } ?>

				

				
				<?php if ($resultpage['feedbackStar'] != 0) { ?>
				<a href="showpage.crm?module=query&amp;view=yes&amp;id=<?php echo $_REQUEST['id']; ?>&feedback=1" style="padding:10px 20px; float:left; font-size:15px; <?php if ($_REQUEST['feedback'] == 1) { ?>background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115;<?php } else { ?>background-color:#fff; color:#000;  border:1px solid #fff;<?php } ?>"><strong>Client Feedback</strong></a>
				<?php } ?>
			</div>
	<?php if ($_REQUEST['notes'] != 1 && $_REQUEST['quotations'] != 1) { ?>
	<?php if ($resultpage['queryStatus'] == 7 && $resultpage['followupdate'] != '0000-00-00') { ?>
	<div style="padding:20px; background-color:#FF6600; color:#FFFFFF;">
		<table border="0" cellpadding="5" cellspacing="0" style="    font-size: 16px;">
			<tr>
				<td colspan="2" style="color:#FFFFFF;">Follow-Up:</td>
				<td colspan="2" style="color:#FFFFFF;"><strong><?php echo showdate($resultpage['followupdate']); ?></strong></td>
				<?php if ($resultpage['followuptime'] != '') { ?><td colspan="2" style="color:#FFFFFF;">- <?php echo $resultpage['followuptime']; ?></td><?php } ?>
			</tr>
		</table>
	</div>
	<?php } ?>

	<?php if ($resultpage['queryStatus'] == 4 || $resultpage['queryStatus'] == 5 || $resultpage['queryStatus'] == 3 || $resultpage['queryStatus'] == 20) { ?>
	<div class="querywonlostclose" style="<?php if ($resultpage['queryStatus'] == 3) { ?>background-color:#82b767;<?php } ?><?php if ($resultpage['queryStatus'] == 4 || $resultpage['queryStatus'] == 20) { ?>background-color:#c75858;<?php } ?><?php if ($resultpage['queryStatus'] == 5) { ?>background-color:#4CAF50;<?php } ?> <?php if ($resultpage['moduleType']=='4') { ?>display:none;<?php } ?>">
		<div class="headingwonlc"><?php if ($resultpage['queryStatus'] == 3) { ?>Query Confirmed<?php } ?><?php if ($resultpage['queryStatus'] == 4) { ?>Query Lost<?php } ?><?php if ($resultpage['queryStatus'] == 5) { ?>Quotation Generated<?php } ?><?php if ($resultpage['queryStatus'] == 20) { ?>Cancelled<?php if ($resultpage['queryCloseDetails'] != '') { ?><br />
			<div style="font-size:12px;"><strong>Note:</strong> <?php echo clean($resultpage['queryCloseDetails']); ?></div><?php }
			} ?>
		</div>
		<?php if($resultpage['queryStatus']!=20 && $resultpage['followupdate']!='0000-00-00') { ?>
		<div style="font-size:12px; margin-bottom:5px;"><strong>End Date:</strong> <?php echo ($resultpage['followupdate']); ?></div>
		<?php } ?>
		<?php if($resultpage['queryCloseDetails']!='' && $resultpage['queryStatus'] != 20){ ?><div style="font-size:12px; margin-bottom:5px;"><strong>Remark: </strong><?php echo stripslashes($resultpage['queryCloseDetails']); ?></div><?php } ?>
		<?php if($resultpage['followuptime']!='' && $resultpage['queryStatus'] != 20){ ?><div style="font-size:12px; margin-bottom:5px;"><strong>End Time: </strong><?php echo stripslashes($resultpage['followuptime']); ?></div><?php } ?>
		<?php if($resultpage['queryStatus']==3){ ?>
		<!--<a  onclick="alertspopupopen('action=cancelqueryopenbox&queryId=<?php echo $_GET['id']; ?>','450px','auto');" style=" position:absolute; right:20px; top:27px;"><input name="addnewuserbtn2" type="button" class="bluembutton  submitbtn" id="addnewuserbtn2" value="Cancel Query" style="
			background-color: #ea0000 !important;
			border: 1px #ea0000 solid !important;
		"></a>-->
		<?php } ?>
	</div>
	<?php }
	} ?>

	<?php if ($_REQUEST['feedback'] == 1) { ?>
	<div style="padding:20px;">
	<div style="padding:20px; background-color:#fff; border:1px solid #ccc;">
	<div style="font-size:16px; margin-bottom:10px;">Rating: <span style="font-size: 25px;
		display: inline-block;
		background-color: #464646;
		padding: 2px 10px;
		color: #fff;
	border-radius: 3px;"><?php echo $resultpage['feedbackStar']; ?></span></div>
	<div style="font-size:16px; margin-bottom:10px;">Comment: <?php echo $resultpage['feedbackComment']; ?></div>
	<div style="font-size:12px; margin-bottom:10px; color:#999999;">Comment: <?php echo date('j F Y - h:i A', strtotime($resultpage['feedbackDate'])); ?></div>
	</div>
	</div>
	<?php } ?>
	<?php
	// CLIENT COMMUNICATION TAB
	if ($_REQUEST['notes'] != 1 && $_REQUEST['supplier'] != 1 && $_REQUEST['quotations'] != 1 && $_REQUEST['b2bquotation'] != 1  && $_REQUEST['feedback'] != 1 && $_REQUEST['guestlist'] != 1 && $_REQUEST['tourextension'] != 1 && $resultpage['moduleType'] == 1) { ?>
	<div class="replyboxmain" id="replymainbox">
		<div style="padding: 0px; border: 1px solid #dadadabd;  box-shadow: 1px 1px 10px #cccccc87;">
		<div class="headingrep" style="margin:0px; padding:10px; background-color:#e7e7e7; font-size:13px; font-weight:500;"><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp; Reply (Please Write Down OR Copy Paste Your Query) </div>
		<div class="mailusers" style="margin:0px; padding:10px;background-color: #fff;">
		<div class="mailusersbox"><strong><i class="fa fa-envelope" aria-hidden="true"></i> Client</strong> &nbsp;<?php echo  $resultpage['guest1email']; ?></div>
		<div class="mailusersbox"><strong><i class="fa fa-envelope" aria-hidden="true"></i> Operation Person</strong> &nbsp;<?php echo $resultpageassignemail['email']; ?></div>

		<style>
		.mailusersbox strong {
		display: block;
		font-size: 10px;
		font-weight: 500;
		margin: 3px 0px;
		background-color: #efefef;
		padding: 4px;
		color: #000000a3;
		text-transform: uppercase;
		}

		.mailusers .mailusersbox {
		margin: 0px 5px 5px 0px;
		}
		</style>
		<?php
		if ($resultpage['clientType'] == 1) {
		$select22 = '';
		$where22 = '';
		$rs22 = '';
		$select22 = '*';
		$where22 = 'id="' . $resultpage['companyId'] . '"';
		$rs22 = GetPageRecord($select22, _CORPORATE_MASTER_, $where22);
		$ddd = mysqli_fetch_array($rs22);
		$select333 = '';
		$where333 = '';
		$rs333 = '';
		$select333 = '*';
		$where333 = 'id="' . $ddd['assignTo'] . '"';
		$rs333 = GetPageRecord($select333, _USER_MASTER_, $where333);
		if (mysqli_num_rows($rs333) > 0) {
		$kk = mysqli_fetch_array($rs333);
		$corporatesalesperson = $kk['email'];
		}

		$select = '';
		$where = '';
		$rs = '';
		$select = '*';
		$where = 'queryid="' . decode($_GET['id']) . '" and fromMail="" order by adddate desc limit 0,1';
		$rs = GetPageRecord($select, _QUERYMAILS_MASTER_, $where);
		$querylisting31 = mysqli_fetch_array($rs);
		if ($querylisting31['multiemails'] != '') {
			$multiemails3 = $querylisting31['multiemails'];
		}

		?>

		<div class="mailusersbox"><strong><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;Sales Person</strong> <?php echo $corporatesalesperson; ?></div>

		<?php } ?>

		<div class="mailusersbox"><strong><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;Group</strong><?php echo $resultpageemail['queryemail'] . ',' . $multiemails3; ?></div>
		</div>
		</div> 
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
		<div style="margin:10px 0px; padding:0px; overflow: visible; margin-bottom:10px;" class="addeditpagebox">
		<?php if ($resultpage['quotationYes'] != 1 && $resultpage['quotationYes'] != 2) { ?>
		<div style="padding: 10px;
		color: #fff;
		font-size: 16px;
		position: relative;
		background-color: #373d46;
		overflow: hidden;
		margin-top: 10px;
		font-weight: 500 !important;
		border-left: 5px #4caf50 solid;"><strong style="float:left; padding: 4px; cursor:pointer; font-weight:500;" onClick="funloadQueryPackage();openitineryedit();">Itinerary</strong>

		<a style="padding: 5px 13px;
		background-color: #2ca1cc;
		color: #fff!important;
		float: right;
		font-size: 14px;
		border-radius: 20px;" id="edititti" onClick="openitineryedit();funloadQueryPackage();"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Itinerary</a>


		<a style="padding: 5px 13px;
		background-color: #2ca1cc;
		color: #fff!important;
		float: right;
		font-size: 14px;
		border-radius: 20px; display:none;" id="closeitti" onClick="openitineryedit();">Close</a>
		</div>
		<?php } ?>
		<div style="padding: 0px; border: 1px solid #dadadabd;  box-shadow: 1px 1px 10px #cccccc87; background-color:#fff;">
		<div id="loadQueryPackage" style="display:none;overflow:hidden;"></div>
		</div>

		<div style="padding: 0px; border: 1px solid #dadadabd;  box-shadow: 1px 1px 10px #cccccc87; padding:10px; background-color:#fff;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td width="29%" valign="top">
			<div class="griddiv"><label>
			<div style="  border-bottom:1px #d8d8d8 solid; padding-bottom:5px; color:#8a8a8a; border-bottom:0px;">File From Desktop</div>
			<div id="ulList"></div>
			<div class="addguestbutton" style="margin: 0px;padding: 7px;margin-top: 0px;font-size: 16px;" id="chosefileoption"><i class="fa fa-upload" aria-hidden="true"></i> Choose File</div>
				<script>
				$('#chosefileoption').click(function() {
					$('input[type="file"]').change(function(e) {
					var fileName = e.target.files[0].name;
						$("#ulList").append(fileName);
						// alert('The file "' + fileName +  '" has been selected.');
					});
					$('#attachmentFile').trigger('click');
				});
				</script>
			</label>
			</div>
			<div <?php if ($_REQUEST['quotationId']=='') { ?>style="display:none;" <?php } ?>>

				<?php
				if($_REQUEST['sendfeedbackform'] != ''){ }else{

				?>
				<div class="griddiv" style="margin-bottom:0px;">
				<label>

				<div class="gridlable" style="width:100%">Attach<span class="redmind"></span></div>
				<select id="attachitinerary" name="attachitinerary" class="gridfield" autocomplete="off" style="height:38px;">
				<?php
				if ($_REQUEST['quotationId'] == '') { ?>
				<option value="1">No</option>
				<?php
				}
				$q1n = 0;
				$rsps = GetPageRecord('*', _QUOTATION_MASTER_, ' id="' . decode($_REQUEST['quotationId']) . '" and deletestatus=0 order by quotationNo asc');
				if (mysqli_num_rows($rsps) > 0) {
				while ($resIti = mysqli_fetch_array($rsps)) {
				?>
				<option value="<?php echo $resIti['id']; ?>">Itinerary <?php echo makeQuotationId($resIti['id']); ?> </option>
				<?php
				}
				}
				?>
				</select>
				</label>
				</div>
				<?php } ?>
			</div>
			
		</td>
		<td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="29%" valign="top">
			<div style="overflow:hidden;margin-bottom:0px;display: none;">
				<div style="  border-bottom:0px #d8d8d8 solid; padding-bottom:10px; color:#8a8a8a;">File - Document Mngmt</div>
				<div id="selecteddocumentfiles"></div>
				<div class="addguestbutton" style="margin: 0px;padding: 10px;font-size: 16px;" 
				onclick="masters_alertspopupopen('action=addeditGallery&galleryType=other&parentId=126&module=packagehotelmaster&page=addGallery','800px','auto');"
				onClick="alertspopupopen('action=selectattachementdocumentfile','800px','auto');"> <i class="fa fa-folder-open" aria-hidden="true"></i> Select File</div>
			</div>

			<div class="griddiv" style="border-bottom: 0px; margin-bottom:0px;"><label>
				<div class="gridlable" style="width:100%; border-bottom:0px;">Reply Template</div>

				<script>
				function emailloadotherItinerary() {
					var emailTemplateId = $('#emailTemplateId').val();
					var queryId = '<?php echo $resultpage['id']; ?>';
					var clientName = '<?php echo showClientTypeUserName($resultpage['clientType'], $resultpage['companyId']); ?>';
					$('#mainreplybox').load('frmaction.php?id=' + emailTemplateId + '&action=loadWelcomeNote&queryId=' + queryId + '&clientName=' + encodeURI(clientName) + '&curren=<?php echo $_REQUEST['curren']; ?>&quotationId=<?php echo decode($_REQUEST['quotationId']); ?>');
				}

				$('#emailTemplateId').val();
				</script>
				</label><select id="emailTemplateId" name="emailTemplateId" class="gridfield" onchange="emailloadotherItinerary(this.value)"   style="padding:10px; border:1px #CCCCCC solid; margin-bottom:5px; width:100%; box-sizing:border-box;">
				<option value="">Select Template</option>
				<?php
				$select = '';
				$where = '';
				$rs = '';
				$select = '*';
				$where = ' deletestatus=0  order by id asc';
				$rs = GetPageRecord($select, _EMAIL_TEMPLATE_MASTER_, $where);
				while ($resListing = mysqli_fetch_array($rs)) {
				?>
				<option value="<?php echo strip($resListing['id']); ?>" <?php if ( ($resListing['id'] == $emailTemplateId) || ( $resListing['isDefault'] == 1) &&  $emailTemplateId=='') { ?>selected="selected" <?php } ?>><?php echo strip($resListing['subject']); ?></option>
				<?php } ?>
				</select>
			</div>
		</td>
		<td width="1%" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="29%" valign="top"> 
			<?php
			$rs = '';
			$rs = GetPageRecord('*', _QUERYMAILS_MASTER_, 'queryid="' . decode($_GET['id']) . '" and fromMail="" order by adddate desc limit 0,1');
			while ($querylisting2 = mysqli_fetch_array($rs)) {
				$multiemails = $querylisting2['multiemails'];
			}
			?>
			<div class="griddiv" style="margin-bottom:0px;"><label>
			<div class="gridlable" style="width:100%;">CC:(Comma Separated Emails) </div>
			<input name="multiemails" type="text" class="gridfield" id="multiemails" placeholder="test@example.com,test@example.com" value="<?php echo strip($multiemails); ?>" style=" padding: 10px; " />
			</label>
			</div>
 		</td>
		</tr>

		<tr <?php if ($resultpage['quotationYes'] == 1) { ?> style="display:none;" <?php } ?>>

		<td colspan="5" valign="top"> </td>
		</tr>
		<tr>
		<td colspan="5" valign="top"></td>
		</tr>
		<script>
		function openitineryedit() {
		$('#edititti').toggle();
		$('#closeitti').toggle();
		$('#loadQueryPackage').toggle();
		}


		function funloadQueryPackage() {
		$('#loadQueryPackage').load('loadQueryPackage.php?id=<?php echo $resultpage['id']; ?>');
		}
		//funloadQueryPackage();
		function deleteItinerary() {
		var r = confirm("Are you sure want to delete this Itinerary?")
		if (r == true) {
		$('#loadQueryPackage').load('loadQueryPackage.php?id=<?php echo $resultpage['id']; ?>&dlt=1');
		}
		}
		</script>
		</table>
		</div>
		</div> 
		<?php
		$invoice = '';
		if ($_GET['invoice'] == 1) {
		$invoice = url_get_contents('' . $fullurl . 'loaddmcinvoice.php?id=' . decode($_GET['id']) . '');
		}
		$reminvoice = '';
		if ($_GET['reminvoice'] == 1) {
		$reminvoice = url_get_contents('' . $fullurl . 'load_remittance_invoice.php?id=' . decode($_GET['id']) . '');
		}
		$supminvoice = '';
		if ($_GET['supminvoice'] == 1) {
		$supminvoice = url_get_contents('' . $fullurl . 'load_supplementary_invoice.php?id=' . decode($_GET['id']) . '');
		}
		$itinerary = '';
		if ($_GET['itinerary'] == 1) {
		$itinerary = '<div style="width:800px; border:1px solid #ccc; padding:5px;">' . url_get_contents('' . $fullurl . 'itinerarypdf.php?id=' . ($_GET['id']) . '') . '</div>';
		}
		if ($_GET['quotationitinerary'] == 1) {

		$itinerary = '<div style="width:800px; border:1px solid #ccc; padding:5px;">' . url_get_contents('' . $fullurl . 'download_quotations_itinerary.php?qid=' . $_REQUEST['newqid'] . '&queryId=' . decode($_GET['id'])) . '</div>';
		}
		?>
		<div id="mainreply"> 

		<?php
		// sub-series dates for agent confirmation.
		$greetingMsg='Dear Sir/Ma\'am <br> Greeting from <strong>'.$clientnameglobal.'</strong>.<br><br>';
		// $greetingMsg='Dear Sir/Ma\'am <br> Greeting from <strong>'.$clientnameglobal.'</strong>.<br>While replying to this query, please don\'t change the subject line.<br><br>';

		if($resultpage['moduleType'] == 1 && $_GET['viewQuotation'] == 1){ 
			$replymainbox = 1;
			$d=GetPageRecord('id,quotationType,proposalType',_QUOTATION_MASTER_,' id="'.decode($_REQUEST['quotationId']).'" ');
			$QuotData=mysqli_fetch_array($d);
			// echo decode($_REQUEST['quotationId']);
			$preview = url_get_contents($fullurl.'inboundpackagehtml_0'.$QuotData['proposalType'].'.php?id='.encode($QuotData['id']));
			$preview = removeTagByClass($preview,'calcostsheet');

		}elseif($_REQUEST['voucherString']!= ''){
			$replymainbox = 1;
			// share vouchers to client
			$preview = url_get_contents($fullurl.'loadcreatevoucher_client_html.php?string='.trim($_REQUEST['voucherString']));

		}elseif($_REQUEST['voucherURLString']!= ''){
			$replymainbox = 1;
			// share vouchers to client
			$preview = url_get_contents($fullurl.'loadcreatevoucher_client_html4.php?urlString='.trim($_REQUEST['voucherURLString']).'&allVoucher='.trim($_REQUEST['allVoucherURLString']));

		}elseif($_REQUEST['allvoucher']!= '') {
			$replymainbox = 1;
			// share vouchers to client
			$preview = url_get_contents($fullurl.'loadcreatevoucher_client_html.php?allvoucher='.trim($_REQUEST['allvoucher']));

		}elseif($_REQUEST['invoiceId']!= ''){
			$replymainbox = 1;
			// share vouchers to client
			$invoiceattache = url_get_contents($fullurl.'invoicepdf.php?id='.trim($_REQUEST['invoiceId']));
			$downloadbtn='<a style="text-decoration: none;" href="'.$fullurl.'tcpdf/examples/getpdf.php?pageurl='.$fullurl.'invoicepdf.php?id='.trim($_REQUEST['invoiceId']).'"><div style="font-size: 16px; padding: 14px 60px; background-color: #45b558; color: #fff;display: inline-block;margin-bottom: 20px; text-decoration: none; border-radius: 4px;">Download Invoice</div></a>';
			$preview = ''.$invoiceattache.'<br><br>Please find attached invoice<br><br>'.$downloadbtn.'<br><br>';

		}elseif($_REQUEST['scheduleId']!='' && $_REQUEST['scheduleSuppId']!=''){
			$replymainbox = 1;
			$preview ='<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width">';
			$preview .= url_get_contents($fullurl.'supplierPaymentReceipt_html.php?scheduleId='.trim($_REQUEST['scheduleId']).'&scheduleSuppId='.trim($_REQUEST['scheduleSuppId']).'&quotationId='.trim($_REQUEST['quotationId']).'&queryId='.trim($_REQUEST['queryId']));
		}elseif($_REQUEST['scheduleId']!=''){
			$replymainbox = 1;
			$preview = url_get_contents($fullurl.'paymentReceipt_html.php?scheduleId='.trim($_REQUEST['scheduleId']).'&quotationId='.trim($_REQUEST['quotationId']).'&queryId='.trim($_REQUEST['id']));
		}elseif($_REQUEST['agentpaymentrequestLink']!=''){
			// payment request link file
			$replymainbox = 1;
			$preview = url_get_contents($fullurl.'loadagentpaymentrequestLink.php?scheduleId='.trim($_REQUEST['paymentscheduleId']).'&quotationId='.trim($_REQUEST['quotationId']).'&queryId='.trim($_REQUEST['id']));
		}elseif($_REQUEST['scheduledAmount']==='yes'){
			$replymainbox = 1;
			$preview = url_get_contents($fullurl.'scheduledPaymentReceipt.php?agentPaymentId='.trim($_REQUEST['agentPaymentId']).'&quotationId='.trim($_REQUEST['quotationId']).'&queryId='.trim($_REQUEST['id']));
		}elseif($_REQUEST['welcomeLetter']==='yes'){
			$replymainbox = 1;
			$preview = url_get_contents($fullurl.'loadwelcomevoucher.php?queryId='.trim(decode($_REQUEST['id'])).'&welcomeLetter=yes');
		}elseif($_REQUEST['planinwelcomeLetter']==='yes'){
			$replymainbox = 1;
			$preview = url_get_contents($fullurl.'loadplainwelcomevoucher.php?queryId='.trim(decode($_REQUEST['id'])).'&planinwelcomeLetter=yes');
		}elseif($_REQUEST['propURL']!=''){
			$replymainbox = 1; 
			$preview ='<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width">';
			$preview .= url_get_contents(decode($_REQUEST['propURL']));
			$preview = removeTagByClass($preview,'calcostsheet');
			$preview = removeTagByClass($preview,'removeDiv');
			$preview .= "<br><a href='".decode($_REQUEST['propURL'])."' target='_blank' width='300' style='border: 1px solid #3e7ded; border-radius: 50px; padding: 5px 15px; text-decoration: none; background-color: #fff; cursor: pointer;'>Click here open in browser</a><br><br>";
  
		}elseif($_REQUEST['dmcvoucher']!=''){
			// share dmc voucher to client
			$replymainbox = 1;
			$preview = url_get_contents($fullurl.'loadcreatevoucher_client_html_dmc.php?quotationId='.decode($_REQUEST['quotationId'])); 
		}
	

		$description = $preview;
		?>
		<textarea name="description" rows="10" class="gridfield" id="description" style="height:200px;"><?php 
		echo ($greetingMsg); ?>
		</textarea>
		<?php if(strlen(trim($description))>20){  ?>
		<br />
		<textarea name="descriptionPdf" rows="20" class="gridfield" id="descriptionPdf" style="height:200px;"><?php 
		echo ($description); ?>
		</textarea>
		<?php } ?> 

		<div id="mainreplybox" style="display:none"></div>
		</div>
		<?php if($_REQUEST['voucherString']!='' || $_REQUEST['voucherURLString']!=''){
			?>
			<div style="font-size: 15px;padding: 10px 0;border: 1px solid #dadadabd;box-shadow: 1px 1px 10px #cccccc87; background-color:#fff;">
				<label for="isAttachement">
					<input type="checkbox" id="isAttachement"  name="isAttachement" value="1" style="display: inline-block;width: 15px;height: 15px;">&nbsp;&nbsp;&nbsp;Attach as PDF.</label>  
					<?php if($_REQUEST['voucherURLString']!=''){ ?>

					<input name="voucherURLString" id="voucherURLString" type="hidden" value="<?php echo trim($_REQUEST['voucherURLString']); ?>" /> 

					<input name="allVoucher" id="allVoucher" type="hidden" value="<?php echo trim($_REQUEST['allVoucherURLString']); ?>" /> 
				
					<?php }else{ ?>
					<input name="voucherURL" id="voucherURL" type="hidden" value="<?php echo trim($_REQUEST['voucherString']); ?>" />
					<?php } ?>
					
			</div>
		<?php } ?>

		<!-- <textarea name="documentattachement" id="documentattachement" cols="" rows="" style="display:none;"></textarea> -->
		<div class="rightfootersectionheader">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<script>
			function changeintienery() {
				$('#changeintienerystatus').val('1');
			}
		</script>
		<td align="right"><input name="changeintienerystatus" type="hidden" id="changeintienerystatus" value="0" />
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td>
			<input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Send" onClick="submitreplyfrm();$('#loadQueryPackage').html('');" />

			<input name="attachmentFile" type="file" class="gridfield" id="attachmentFile" style="display:none;bottom: 0;width: 0;height: 0;margin: 0;padding: 0;border: 0;" /> 
			<input name="queryreplyid" id="queryreplyid" type="hidden" value="<?php echo $_GET['id']; ?>" />
			<input name="addedit" id="addedit" type="hidden" value="add" />
			<input name="scheduledAmount" id="scheduledAmount" type="hidden" value="<?php echo $_REQUEST['scheduledAmount']; ?>" />
			<input name="assignTo" id="assignTo" type="hidden" value="<?php echo $resultpage['assignTo']; ?>" />
			<input name="companyId" id="companyId" type="hidden" value="<?php echo $resultpage['companyId']; ?>" />
			<input name="subject" id="subject" type="hidden" value="<?php echo $resultpage['subject']; ?>" />
			<input name="clientType" id="clientType" type="hidden" value="<?php echo $resultpage['clientType']; ?>" />
			<input name="totalQueryCost" type="hidden" id="totalQueryCost" value="0" />
			<input name="action" type="hidden" id="action" value="queryreply" />

		</td>
		<td><input type="button" name="Submit2" value="Cancel" class="whitembutton" onClick="$('#replymainbox').hide();$('#replybtn').show();" /></td>
		</tr>
		</table>
		<script>
		function submitreplyfrm() {
		var selecteddocumentfiles = $('#selecteddocumentfiles').html();
		$('#documentattachement').val('<div style="width:400px;"><div style="margin-bottom:10px; font-size:16px;"><strong></strong></div>' + selecteddocumentfiles + '</div>');
		formValidation('addeditfrm', 'submitbtn', '0');
		}
		</script>
		</td>
		</tr> 
		</table>
		</div>
		</form>
	</div>
	    </form>
	</div>
	<?php 
	$select = '';
	$where = '';
	$rs = '';
	$select = '*';
	$wheremails = 'queryid=' . decode($_GET['id']) . ' and deletestatus=0 order by adddate desc';
	// if ($resultpage['toDate'] < date("Y-m-d", strtotime("-1 months"))) {
	// 	$rs = GetPageRecord($select, 'queryAllmailsBackup', $where); 
	//   backup table no more use end on 20 sep 2022
		
	// } else {
		$rs = GetPageRecord($select, _QUERYMAILS_MASTER_, $wheremails); 
	// }
	while ($querylisting = mysqli_fetch_array($rs)) {

		$queryemaildate = $querylisting['adddate'];
		$querydate = date("Y-m-d H:i:s", $resultpage['dateAdded']);

		if ($queryemaildate == $querydate) {
			$mailbodydetails = $querylisting['description'];
		} else {
			$details = preg_replace("/<p[^>]*?>/", "", $querylisting['description']);
			$details = str_replace("</p>", "<br />", $details);
			$details =  preg_replace('/(?:\s*<br[^>]*>\s*){3,}/s', "<br>", stripslashes($details));
			$details =  preg_replace('/^\>/m', '', $details);
			$mailbodydetails = (preg_replace("/<https:>(.*?)<\/https:>/", "$1", $details));
			$mailbodydetails = str_replace('Content-Type: text/plain;', '', $mailbodydetails);
			$mailbodydetails = str_replace('charset="us-ascii"', '', $mailbodydetails);
			$mailbodydetails = str_replace('us-ascii', '', $mailbodydetails);
			$mailbodydetails = str_replace('charset="UTF-8"', '', $mailbodydetails);
			$mailbodydetails = str_replace('Content-Transfer-Encoding: 7bit', '', $mailbodydetails);
			$mailbodydetails = str_replace('Content-Transfer-Encoding: quoted-printable', '', $mailbodydetails);
			$mailbodydetails = str_replace('charset="utf-8"', '', $mailbodydetails);
		}
		if ($mailbodydetails != '') {
		?>
		<div class="querymaillisting" style="display:flex;border-left:4px solid #<?php if ($querylisting['queryStatus'] == 1) {
		echo '2ca1cc';
		}
		if ($querylisting['queryStatus'] == 2) {
		echo 'FF6600';
		}
		if ($querylisting['queryStatus'] == 3) {
		echo 'wonquery';
		}
		if ($querylisting['queryStatus'] == 4) {
		echo 'lossquery';
		}
		if ($querylisting['queryStatus'] == 5) {
		echo '2ca1cc';
		}
		if ($querylisting['queryStatus'] == 0) {
		echo '2ca1cc';
		} ?>;" onClick="getbody('<?php echo $querylisting['id']; ?>');showcontenttab(<?php echo $querylisting['id']; ?>);$('#titleid<?php echo $querylisting['id']; ?>').removeClass('strong');changequerystatus(<?php echo $querylisting['id']; ?>);" id="maintab<?php echo $querylisting['id']; ?>">
		
		<div class="fa fa <?php if($querylisting['fromMail']!=''){ ?>fa-mail-forward<?php } else {  ?>fa-mail-reply<?php } ?>" aria-hidden="true" style="color: #<?php if ($querylisting['fromMail'] != '') { echo '2ca1cc'; }else{ echo 'FF6600'; } ?>;"></div>
		<div class="maintitle<?php if ($querylisting['status'] == 1) { ?> strong<?php } ?>" id="titleid<?php echo $querylisting['id']; ?>"><?php echo strip(substr(strip_tags(str_replace('<p>&nbsp;</p>', '', $querylisting['description'])), 0, 120)); ?>...</div>

		<div class="datetimequ"><?php if ($querylisting['clientReadmail'] == 0) { ?><div class="nomailread" title="Mail Not Read"></div><?php } else { ?><div class="mailread" title="Mail Read"></div><?php } ?><?php $originalDate = $querylisting['adddate'];
					echo date("g:iA - d-m-Y", strtotime($originalDate)); ?></div>
		</div>
		<div class="displaytab" id="displaymaintab<?php echo $querylisting['id']; ?>">
		<div class="datebox" style="position:relative;"><?php $originalDate = $querylisting['adddate'];
				echo date("g:iA - d-m-Y", strtotime($originalDate)); ?><input name="Close" type="button" class="whitembutton" id="Close" value="Close" style="    position: absolute;  padding: 5px 8px; right: 0px; font-size: 12px;top: -6px;" onClick="hidecontenttab(<?php echo $querylisting['id']; ?>);"></div>
		<div class="mailusers">

		<div class="mailusersbox"><strong>Client: </strong><?php if ($resultpage['clientType'] == 1) {
				echo (getPrimaryEmail($resultpage['companyId'], 'corporate'));
			}
			if ($resultpage['clientType'] == 2) {
				echo getPrimaryEmail($resultpage['companyId'], 'contacts');
			} ?></div>
		<div class="mailusersbox"><strong>Operation Person: </strong><?php echo $resultpageassignemail['email']; ?></div>

		<?php
		if ($resultpage['clientType'] == 1) {
		$select111 = '';
		$where111 = '';
		$rs111 = '';
		$select111 = '*';
		$where111 = 'id=' . $resultpage['companyId'] . '';
		$rs111 = GetPageRecord($select111, _CORPORATE_MASTER_, $where111);
		if (mysqli_num_rows($rs111) > 0) {
		$resultpageassignemail = mysqli_fetch_array($rs111);
		}
		$select111 = '';
		$where111 = '';
		$rs111 = '';
		$select111 = '*';
		$where111 = 'id=' . $resultpageassignemail['assignTo'] . '';
		$rs111 = GetPageRecord($select111, _USER_MASTER_, $where111);
		$resultpageassignemail = mysqli_fetch_array($rs111);
		$corporatesalesperson = $resultpageassignemail['email'];
		?>
		<div class="mailusersbox"><strong>Sales Person: </strong><?php echo $corporatesalesperson; ?></div>
		<?php } ?>
		<div class="mailusersbox"><strong>Group: </strong><?php
		echo $resultpageemail['queryemail'];
		if ($querylisting['multiemails'] != '') {
			$emails = $querylisting['multiemails'];
			// $emails = 'sunakshi@holidayunlimited.in';
			// $emails = "\"sunakshi\" <sunakshi@holidayunlimited.in>, \"Rahul khare\" <rahul@holidayunlimited.in>";
			$emails = extract_emails_from($emails);
			echo ','.implode(',',$emails);
		}  
		?> 
		</div>
		<?php if ($querylisting['fromMail'] != '') { ?><div class="mailusersbox"><strong>From: </strong><?php echo $querylisting['fromMail']; ?></div><?php } ?>
		</div>
		<div id="querymailbody<?php echo $querylisting['id']; ?>">Loading...</div>
		</div>
		<?php 
		}
	}
} ?>
	<?php if ($_REQUEST['notes'] == 1) { ?>
	<div id="loadquerynotes"></div>
	<script>
		function loadquerynotes(delid) {
	$('#loadquerynotes').load('loadquerynotes.php?id=<?php echo $resultpage['id']; ?>&dltid=' + delid);
	}
	loadquerynotes('');
	</script>
	<?php } ?>
	<?php 
	 
	// SUPLIER COMMUNICATION TAB
	if ($_REQUEST['supplier'] == 1){
		if ($_REQUEST['supplierId']!= '' && $_REQUEST['quotationId']!= '') {
	        // greeting masg
			$greetingMsg='Dear Sir/Ma\'am <br> Greeting from <strong>'.$clientnameglobal.'</strong>.<br><br>';

			if($_REQUEST['availability'] == 1 || $_REQUEST['queryAvailability'] == 1) {
				$preview = url_get_contents($fullurl . 'loadhotelAvailabitlityPreviewhtml.php?queryId=' . decode($_REQUEST['id']) . '&quotationId=' . decode($_REQUEST['quotationId']) . '&supplierId=' . decode($_REQUEST['supplierId']));
			}elseif($_REQUEST['voucherString']!=''){
				// share vouchers to suppliers
				$preview = url_get_contents($fullurl.'loadcreatevoucher_both_html.php?string='.trim($_REQUEST['voucherString'])); 
			}else{
				$preview = url_get_contents($fullurl . 'loadSupplierConfirmationPreviewhtml.php?quotationId=' . decode($_REQUEST['quotationId']).'&supplierId=' . decode($_REQUEST['supplierId']));
			}

			$description = $greetingMsg.$preview;

			$rsss = GetPageRecord('*', 'suppliercontactPersonMaster', ' corporateId=' . decode($_REQUEST['supplierId']) . ' and contactPerson!="" and deletestatus=0 order by id asc');
			$resListing = mysqli_fetch_array($rsss);
			?>
			<script src="tinymce/tinymce.min.js"></script>
			<script type="text/javascript">
				tinymce.init({
					selector: "#descriptionsup",
					themes: "modern",
					plugins: [
					"advlist autolink lists link image charmap print preview anchor",
					"searchreplace visualblocks code fullscreen"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			</script>
		<div style="margin:10px;">
		<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="makeQuotation" target="actoinfrm" id="makeQuotation">
		<div style="padding: 0px; border: 1px solid #dadadabd;  box-shadow: 1px 1px 10px #cccccc87; padding:10px; background-color:#fff;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td width="39%" valign="top">
		<div class="gridlable" style="width:100%;color: #8a8a8a; display: inline-block; padding-bottom: 0px; font-size: 13px; ">Name</div>
		<select name="SupplierDivisionName" id="SupplierDivisionName" onchange="loadsupplierconfirmationemail(this.value);" class="gridfield" style="display: inline-block; outline: 0px; padding-bottom: 0px; width: 100%; background-color: #FFFFFF; font-size: 14px; border: 1px #e0e0e0 solid; box-sizing: border-box; height: auto; padding: 8px; margin-top: 5px; border-radius: 2px;">
		<option value="">Select</option>
		<?php
		$rsss = GetPageRecord('id,contactPerson,division', 'suppliercontactPersonMaster', '1 and corporateId="' . decode($_REQUEST['supplierId']) . '" and contactPerson!="" and deletestatus=0 order by id asc');
		while ($resListing = mysqli_fetch_array($rsss)) {
		$divisionDataq = GetPageRecord('name', _DIVISION_MASTER_, '1 and id="' . $resListing['division'] . '"');
		$divisionData = mysqli_fetch_array($divisionDataq);
		?>
		<option value="<?php echo encode($resListing['id']); ?>"><?php echo $resListing['contactPerson']; ?> - <?php echo $divisionData['name']; ?></option>
		<?php } ?>
		</select>
		</td>
		<td width="1%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td width="60%" valign="top" id="loadsupplierconfirmationemail">
		<div class="gridlable" style="width:100%;color: #8a8a8a; display: inline-block; padding-bottom: 0px; font-size: 13px; ">Supplier</div>
		<input name="multiemails" type="text" class="gridfield" id="multiemails" placeholder="Supplier Email" style="display: inline-block; outline: 0px; padding-bottom: 0px; width: 100%; background-color: #FFFFFF; font-size: 14px; border: 1px #e0e0e0 solid; box-sizing: border-box; height: auto; padding: 8px; margin-top: 5px; border-radius: 2px;" readonly />
		</td>
		<script>
		function loadsupplierconfirmationemail(id) {
		$('#loadsupplierconfirmationemail').load('loadsupplierconfirmationemail.php?id=' + id);
		}
		</script>
		</tr>
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td colspan="2" width="100%" valign="top">&nbsp;</td>
		</tr>
		<tr>
		<td colspan="2" width="100%" valign="top">
		<div class="gridlable" style="width:100%;color: #8a8a8a; display: block; padding-bottom: 0px; font-size: 13px; ">Add More Emails</div>
		<select name="ccSupplier[]" multiple="multiple" class="gridfield js-example-basic-multiple" id="ccSupplier" autocomplete="off" style="display: block; outline: 0px; padding-bottom: 0px; width: 100%; background-color: #FFFFFF; font-size: 14px; border: 1px #e0e0e0 solid; box-sizing: border-box; height: auto; padding: 8px; margin-top: 5px; border-radius: 2px;">
		<?php
		$rsss = GetPageRecord('id,contactPerson,division,email', 'suppliercontactPersonMaster', '1 and corporateId="' . decode($_REQUEST['supplierId']) . '" and contactPerson!="" and deletestatus=0 order by id asc');
		while ($resListing = mysqli_fetch_array($rsss)) {
		$divisionDataq = GetPageRecord('name', _DIVISION_MASTER_, '1 and id="' . $resListing['division'] . '"');
		$divisionData = mysqli_fetch_array($divisionDataq);
		?>
		<option value="<?php echo decode($resListing['email']); ?>"><?php echo $resListing['contactPerson']; ?> - <?php echo decode($resListing['email']); ?> - <?php echo $divisionData['name']; ?></option>
		<?php } ?>
		</select>
		</td>
		</tr>
		</table>

		<script type="text/javascript" src="plugins/select2/select2.min.js"></script>
		<script>
		comtabopenclose('linkbox', 'op2'); 
		$(".js-example-basic-multiple").select2({
		tags: true,
		tokenSeparators: [',', ' ']
		})
		</script>

		</div>
		<textarea name="descriptionsup" rows="20" class="gridfield" id="descriptionsup" style="height:220px;"><?php echo $description; ?></textarea>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td align="right"><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Send Mail   " onClick="formValidation('makeQuotation','submitbtn','0');" />
		<input name="action" type="hidden" id="action" value="sendsuppconfirmation" />
		<input name="queryId" id="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
		<input name="quotationId" id="quotationId" type="hidden" value="<?php echo decode($_REQUEST['quotationId']); ?>" />
		<input name="suppId" id="suppId" type="hidden" value="<?php echo decode($_REQUEST['supplierId']); ?>" />
		</td>
		</tr>
		</table>
		</form>
		</div>
		<?php 
	} else { ?>
			<div id="loadquerynotes"></div>
			<script>
			function loadquerysupplier() {
			$('#loadquerynotes').load('loadquerysupplier.php?id=<?php echo $resultpage['id']; ?>');
			}
			loadquerysupplier();
			</script>
			<?php 
		}
	} ?> 
	<?php if ($_REQUEST['b2bquotation'] == 1 || $resultpage['moduleType'] == 2 || $resultpage['moduleType'] == 3 || $resultpage['moduleType'] == 4) {
		mysqli_query(db(), "delete from " . _QUOTATION_MASTER_ . " where deletestatusDuplicate='1'") or die(mysqli_error(db()));
	?>
	<div style="padding:15px;">
	<table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablesorter gridtable">
	<thead>
	<tr width="100%">
		<th width="25%" align="left" class="header">
			<div align="left">
				<!-- Quotation button add 111 -->
				<?php if ($resultpage['moduleType'] == 1) { ?>Quotation&nbsp;ID. <?php } ?>
				<?php if ($resultpage['moduleType'] == 2) { ?>Sub/Series&nbsp;Name. <?php } ?>
				<?php if ($resultpage['moduleType'] == 3) { $modulesurl = '&package=yes'; ?>Fixed&nbsp;Departure&nbsp;ID. <?php } ?>
				<?php if ($resultpage['moduleType'] == 4) { $modulesurl = '&package=yes'; ?>Package&nbsp;ID. <?php } ?>
			</div>
		</th>
		<?php if ($resultpage['moduleType'] == 2) { ?><th align="left" class="header">Sub/Series&nbsp;Code</th>
		<th align="left" class="header">Tour Code</th><?php } ?>
		<!--<th  align="left" class="header">Query Id</th>-->
		<th width="10%" align="left" class="header">
			<div align="left"><?php if ($resultpage['dayWise'] == 1 || $resultpage['moduleType'] == 2 || $resultpage['moduleType'] == 3 || $resultpage['moduleType'] == 4) { ?>FromDate<?php } ?></div>
		</th>
		<th width="10%" align="left" class="header">
			<div align="left"><?php if ($resultpage['dayWise'] == 1 || $resultpage['moduleType'] == 2 || $resultpage['moduleType'] == 3 || $resultpage['moduleType'] == 4) { ?>To&nbsp;Date<?php } ?> </div>
		</th>
		<th width="8%" align="left" class="header">
			<div align="left">Duration</div>
		</th>
		<?php if ($resultpage['moduleType'] == 3 || $resultpage['moduleType'] == 4) { ?><th align="left" class="header">Status</th><?php } ?>
		<?php if ($resultpage['moduleType'] == 2) { ?><th align="left" class="header">Status</th>
		<th align="left" class="header">Active/Inactive</th><?php } ?>
		<?php if ($resultpage['moduleType'] == 1) { ?><th colspan="6" align="center" class="header">Action</th><?php } ?>
		<?php if ($resultpage['moduleType'] == 2 || $resultpage['moduleType'] == 3 || $resultpage['moduleType'] == 4) { ?><th colspan="4" align="left" class="header">Action</th><?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php
	$no = 1;
	$qn = 0;
	$select = '*';
	$where = '';
	$rs = '';
	$wheresearch = '';
	$limit = ($_GET['records']>0)?$_GET['records']:50;  
	$searchField = clean(trim(ltrim($_GET['searchField'], '0')));
	$mainwhere = $resultpage['id'];
	$where = 'where queryId="' . $resultpage['id'] . '" and deletestatus=0 and queryType="'.$queryTypeId.'" and isTourEx=0 order by dateAdded asc';
	$page = $_GET['page'];
	$targetpage = $fullurl . 'showpage.crm?module=quotations&records=' . $limit . '&searchField=' . $searchField . '&';
	$rs = GetRecordList($select, _QUOTATION_MASTER_, $where, $limit, $page, $targetpage);
	$totalentry = $rs[1];
	$paging = $rs[2];
	while ($resultlists = mysqli_fetch_array($rs[0])) {
		//delete the quotaiton if not duplicated succesfully
		$numQutationQuery = GetPageRecord('*', 'newQuotationDays', 'quotationId=' . $resultlists['id'] . ' and addstatus=0');
		if (mysqli_num_rows($numQutationQuery) < 1 && $queryTypeId!=13) {
			$sql_del = "delete from quotationMaster where id='" . $resultlists['id'] . "'";
			mysqli_query(db(), $sql_del) or die(mysqli_error(db()));
			$sql_del = "delete from newQuotationDays where quotationId='" . $resultlists['id'] . "'";
			mysqli_query(db(), $sql_del) or die(mysqli_error(db()));
		}
		$g = '1';
		$makeQueryId = makeQuotationId($resultlists['id']);
		//check is having final quotation
		$haveFinalQuery = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId=' . $resultlists['queryId'] . ' and status=1 and deletestatus=0');
		$rsp2 = GetPageRecord('*', 'quotationHotelMaster', 'quotationId=' . $resultlists['id'] . ' and isHotelSupplement=1');
	?>
	<tr style=" <?php if ($resultlists['lostStatus'] == 1) { ?>background-color: #b46767; border: 3px solid #b46767; color: #ffffff !important; <?php } elseif ($resultlists['status'] == 1) { ?> background-color: #deffe0; border: 3px solid #6cc791;<?php } elseif ($resultlists['status'] == 2) { ?><?php } elseif ($resultpage['queryStatus'] == 20) { ?> background-color: #c75858;<?php } ?> ">
		<td align="left">
			<div align="left">
				<a <?php if ($resultpage['queryStatus'] == 20 || $resultlists['lostStatus'] == 1 || ($resultlists['queryType'] == 3 && $resultpage['moduleType'] == 1)) { ?> href="showpage.crm?module=quotations&view=yes&id=<?php echo encode($resultlists['id']).$modulesurl; ?>" <?php } else {
					if ($resultlists['status'] != 1 ){ ?> href="showpage.crm?module=quotations&view=yes&id=<?php echo encode($resultlists['id']).$modulesurl; ?>" <?php } else { ?> onclick="alert('Final Proposal can\'t be edited.');" <?php }
					} ?>>
					<?php
					if ($resultpage['moduleType'] == 1) {
						echo $makeQueryId;
					}
					if ($resultpage['moduleType'] == 2) {
						if ($resultlists['isSeries'] == 0) {
							echo $resultpage['seriesName'];
						} else {
							echo $resultlists['subName'];
						}
					}
					if ($resultpage['moduleType'] == 3) {
						if ($resultlists['isFD'] == 0) {
							echo $resultpage['FDCode'];
						} else {
							echo $resultlists['subName'];
						}
					}
					if ($resultpage['moduleType'] == 4) {
						echo $resultpage['packageCode'];
					}
					if ($resultlists['status'] == 1) {
						echo " | Final";
					} ?>
				</a>
			</div>
		</td>
		<?php if ($resultpage['moduleType'] == 2) { ?>
		<td width="10%" align="left">
			<?php
			if ($resultlists['isSeries'] == 0) {
				echo $resultpage['seriesCode'];
			} else {
				echo $resultlists['subSeriesCode'];
			} ?>
		</td>
		<td width="10%" align="left">
			<?php
			if ($resultlists['status'] == 1) {
				echo makeSeriesTourId($resultlists['id']);
			} else {
				$tourCodeq = GetPageRecord('id', _QUERY_MASTER_, ' 1 and id in ( select queryId from quotationMaster where quotationId = "' . $resultlists['id'] . '" ) and moduleType=1 and queryStatus=3 and queryConfirmingDate!=""');
				if (mysqli_num_rows($tourCodeq) > 0) {
					$tourCodeData = mysqli_fetch_array($tourCodeq);
					echo makeQueryTourId($tourCodeData['id']);
				}
			}
			?>
		</td>
		<?php } ?>
		<td width="10%" align="left"><?php if($queryTypeId!=13){ if ($resultpage['dayWise'] == 1  || ($resultpage['moduleType'] == 2 && $resultlists['isSeries'] == 1) || ($resultpage['moduleType'] == 3 && $resultlists['isFD'] == 1) || ($resultpage['moduleType'] == 4 && $resultlists['isPackage'] == 1)) { ?> <div align="left"><?php 
		if($resultpage['dayWise'] != 2 ){
		echo date('d-m-Y', strtotime($resultlists['fromDate'])); 
		}
		?></div><?php } } ?></td>
		<td width="10%" align="left">
			<?php if($queryTypeId!=13){ if ($resultpage['dayWise'] == 1 || ($resultpage['moduleType'] == 2 && $resultlists['isSeries'] == 1) || ($resultpage['moduleType'] == 3 && $resultlists['isFD'] == 1) || ($resultpage['moduleType'] == 4 && $resultlists['isPackage'] == 1)) { ?> <div align="left"><?php 
			
			if($resultpage['dayWise'] != 2 ){
			echo date('d-m-Y', strtotime($resultlists['toDate'])); 
			}
			?></div><?php } } ?></td>
			<td width="8%" align="left">
				<div align="left" >
					<?php if($queryTypeId!=13){
					if ($resultpage['dayWise'] == 1) {  ?>
					<?php echo $resultlists['night']; ?>&nbsp;N/&nbsp;<?php echo $resultlists['night'] + 1; ?>&nbsp;D
					<?php } else { ?>
					<?php echo ($resultlists['night'] + 1); ?>&nbsp;Days
					<?php } } ?>
				</div>
			</td>
			<style>
				.saveasbtn {
					border: 1px #cecece solid !important;
					padding: 5px !important;
					border-radius: 2px !important;
					color: #3c3c3c !important;
					background-color: #dcdcdc !important;
					cursor: pointer;
					font-weight: 500;
					float: left;
					width: auto !important;
					font-size: 12px;
				}
			</style>
			<?php if ($resultpage['moduleType'] == 2) { ?>
			<td width="8%" align="left">
				<?php if ($resultlists['isSeries'] == 1) { ?>
				<select id="ConfirmStatus<?php echo $resultlists['id'] ?>" name="ConfirmStatus" class="gridfield " onchange="changeConfirmStatus<?php echo $resultlists['id'] ?>();" style=" padding: 3px 6px; border-radius: 3px; ">
					<option value="0" <?php if ($resultlists['status'] == 0) { ?> selected="selected" <?php } ?>>Pending</option>
					<option value="1" <?php if ($resultlists['status'] == 1) { ?> selected="selected" <?php } ?>>Confirmed</option>
				</select>
				<div id="subSeriesActionDiv" style="display:none;"></div>
				<script type="text/javascript">
				function changeConfirmStatus<?php echo $resultlists['id'] ?>() {
				var quotationId = <?php echo $resultlists['id'] ?>;
				var status = $('#ConfirmStatus<?php echo $resultlists['id'] ?>').val();
				if (status == 0) {
				var conf = confirm('Are you sure you want to change the status Pending.');
				if (conf == true) {
				$('#subSeriesActionDiv').load('subSeriesAction.php?quotationId=' + quotationId + '&action=changeConfirmStatus&status=0');
				}
				} else {
				var conf = confirm('Are you sure you want to change the status Confirmed.');
				if (conf == true) {
				$('#subSeriesActionDiv').load('subSeriesAction.php?quotationId=' + quotationId + '&action=changeConfirmStatus&status=1');
				}
				}
				}
				</script>
				<?php } ?>
			</td>
			<?php } ?>
			<td width="8%" align="left">
				<?php
				if ($resultpage['moduleType'] == 1){ 
					if($resultlists['queryType']==13){
						?>
						<a class="whitebutton" onclick="alertspopupopen('action=addCostSheet_MultiServices&quotationId=<?php echo $resultlists['id']; ?>','1260px','auto');" > 
							<div class="saveasbtn" style="margin-right: 5px;">Costsheet</div> 
						</a>
						<?php 
					}else{
					
					if($resultlists['calculationType']==2){ ?>
						<a class="whitebutton" onclick="alertspopupopen('action=addCostSheet_packagewise&quotationId=<?php echo $resultlists['id']; ?>','1300px','auto');" > 
							<div class="saveasbtn" style="margin-right: 5px;">Costsheet</div> 
						</a>
						<?php 
					}elseif($resultlists['calculationType']==3){ ?>

						<a class="whitebutton" onclick="alertspopupopen('action=addCostSheet_completepackage&quotationId=<?php echo $resultlists['id']; ?>&hotelCategory=<?php echo $resultlists['hotCategory']; ?>&hotelType=<?php echo $resultlists['hotelType']; ?>&quotationType=<?php echo $resultlists['quotationType']; ?>','1000px','auto');" > 
							<div class="saveasbtn" style="margin-right: 5px;">Costsheet</div> 
						</a>

						<?php 
					}else{ ?>
					<a class="whitebutton" onclick="<?php if(($resultlists['quotationType'] == 2 || $resultlists['quotationType'] == 3) && $resultlists['status']!=1){ ?>
						alertspopupopen('action=selectCostSheet&quotationId=<?php echo $resultlists['id']; ?>','400px','auto');
					<?php }else{ ?> 
						alertspopupopen('action=addCostSheet&quotationId=<?php echo $resultlists['id']; ?>','1300px','auto');<?php } ?>" > 
						<div class="saveasbtn" style="margin-right: 5px;">Costsheet</div>  
						</a>
						<?php 
					} 
				}
				} 
  
				if (($resultpage['moduleType'] == 2 && $resultlists['isSeries'] == 1) || ($resultpage['moduleType'] == 3 && $resultlists['isFD'] == 1) || ($resultpage['moduleType'] == 4 && $resultlists['isPackage'] == 1)) { ?>
				<?php if ($resultlists['isActive'] == 0) { ?>
				<a onClick="changeActiveStatus<?php echo $resultlists['id'] ?>();">
					<div style="color: #1a8a1a;margin-right: 5px;text-align:center;">Active</div>
				</a>
				<?php
				$countConfirm = GetPageRecord('id', _QUOTATION_HOTEL_MASTER_, 'quotationId="' . $resultlists['id'] . '" and HotelSupplierStatus=4');
				$countConfirmq = mysqli_num_rows($countConfirm);
				?>
				<input type="hidden" name="countConfirm" id="countConfirm<?php echo $resultlists['id'] ?>" value="<?php echo $countConfirmq; ?>">
				<input type="hidden" name="isActive" id="isActive<?php echo $resultlists['id'] ?>" value="<?php echo $resultlists['isActive']; ?>">
				<?php } else { ?>
				<a onClick="changeActiveStatus<?php echo $resultlists['id'] ?>();">
					<div style="color: #bf0c0c;margin-right: 5px;text-align:center;">Inactive</div>
				</a>
				<input type="hidden" name="isActive" id="isActive<?php echo $resultlists['id'] ?>" value="<?php echo $resultlists['isActive']; ?>">
				<?php } ?>
				<div id="saveActive"></div>
				<script type="text/javascript">
				function changeActiveStatus<?php echo $resultlists['id'] ?>() {
				var quotationId = <?php echo $resultlists['id'] ?>;
				var confirmStatus = <?php echo $resultlists['status'] ?>;
				var status = $('#isActive<?php echo $resultlists['id'] ?>').val();
				var countConfirm = $('#countConfirm<?php echo $resultlists['id'] ?>').val();
				var subName = '<?php echo trim($resultlists['subName']); ?>';
				if (status == 0 && confirmStatus == 1) {
				var conf = confirm('The Sub Series ' + subName + ' has been Confirmed. Would you like to Deactivate it ?');
				if (conf == true) {
				$('#saveActive').load('frmaction.php?queryId=<?php echo encode($resultpage['id']); ?>&quotationId=' + quotationId + '&action=changeQuotationActiveStatus&status=1');
				}
				} else if (status == 0 && countConfirm > 0) {
				var conf = confirm('Hotel Booking is Confirmed for ' + subName + '. Please confirm you want to Deactivate ' + subName);
				if (conf == true) {
				$('#saveActive').load('frmaction.php?queryId=<?php echo encode($resultpage['id']); ?>&quotationId=' + quotationId + '&action=changeQuotationActiveStatus&status=1');
				}
				} else if (status == 0 && countConfirm == 0) {
				var conf = confirm('Please confirm you want to Deactivate ' + subName);
				if (conf == true) {
				$('#saveActive').load('frmaction.php?queryId=<?php echo encode($resultpage['id']); ?>&quotationId=' + quotationId + '&action=changeQuotationActiveStatus&status=1');
				}
				} else {
				var conf = confirm('Please confirm you want to Activate ' + subName);
				if (conf == true) {
				$('#saveActive').load('frmaction.php?queryId=<?php echo encode($resultpage['id']); ?>&quotationId=' + quotationId + '&action=changeQuotationActiveStatus&status=0');
				}
				}
				}
				</script>
				<?php } ?>
			</td>
			<?php if ($resultpage['moduleType'] == 2) { ?>
			<td>
				<?php
				if ($resultlists['isSeries'] != 1 && $resultlists['saveQuotaiton'] == 0) { ?>
				<a href="showpage.crm?module=quotations&view=yes&id=<?php echo encode($resultlists['id']); ?>">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;">Series&nbsp;Costing</div>
				</a>
				<?php }
				if ($resultlists['isSeries'] != 1 && $resultlists['saveQuotaiton'] == 1) { ?>
				<a onClick="alertspopupopen('action=addSubSeries&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultlists['id']; ?>','500px','auto');">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;min-width: 75px;"><i class="fa fa-plus">&nbsp;</i>&nbsp;Sub&nbsp;Series</div>
				</a>
				<?php }
				if ($resultlists['isSeries'] == 1) { ?>
				<a onClick="alertspopupopen('action=addSubSeries&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultlists['id']; ?>','500px','auto');">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;min-width: 75px;"><i class="fa fa-pencil"></i>&nbsp;Sub&nbsp;Series</div>
				</a>
				<?php } ?>
			</td>
			<?php } ?>
			<?php if ($resultpage['moduleType'] == 3) { ?>
			<td>
				<?php
				if ($resultlists['isFD'] != 1 && $resultlists['saveQuotaiton'] == 0) { ?>
				<a href="showpage.crm?module=quotations&view=yes&id=<?php echo encode($resultlists['id']); ?>">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;">Fix&nbsp;Departure&nbsp;Costing</div>
				</a>
				<?php }
				if ($resultlists['isFD'] != 1 && $resultlists['saveQuotaiton'] == 1) { ?>
				<a onClick="alertspopupopen('action=addFixDeparture&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultlists['id']; ?>','500px','auto');">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;"><i class="fa fa-plus">&nbsp;</i>&nbsp;Fix&nbsp;Departure</div>
				</a>
				<?php }
				if ($resultlists['isFD'] == 1) { ?>
				<a onClick="alertspopupopen('action=addFixDeparture&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultlists['id']; ?>','500px','auto');">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;"><i class="fa fa-pencil">&nbsp;</i>&nbsp;Fix&nbsp;Departure</div>
				</a>
				<?php } ?>
			</td>
			<?php } ?>
			<?php if ($resultpage['moduleType'] == 4) { ?>
			<td>
				<?php
				if ($resultlists['saveQuotaiton'] == 1) { ?>
				<a style="display:none;" href="#" onclick="alertspopupopen('action=addCostSheet<?php if ($resultlists['calculationType'] == 3) { ?>_completepackage<?php }else{ ?>_packagewise<?php } ?>&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultlists['id']; ?>','<?php if ($resultlists['calculationType'] == 3) { ?>800px<?php }else{ ?>1300px<?php } ?>','auto');">
					<div style="display:none;" class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;">Package&nbsp;Costing</div>
				</a>
				<?php } ?>
			</td>
			<?php } ?>
			<?php if ($resultpage['moduleType'] == 2 && $resultlists['isSeries'] != 1 && $resultlists['saveQuotaiton'] == 1) { ?>
			<td align="right">
				<a onClick="alertspopupopen('action=hotelAvailability&queryId=<?php echo $_REQUEST['id']; ?>','840px','auto');">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;">Hotel&nbsp;Availability</div>
				</a>
			</td>
			<td align="left">
				<a href="showpage.crm?module=query&view=yes&id=<?php echo encode($resultpage['id']); ?>&quotation=1&curren=<?php echo $resultlists['currencyId']; ?>&quotationId=<?php echo encode($resultlists['id']); ?>" target="_blank">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;">Agent&nbsp;Confirmation</div>
				</a>
			</td>
			<?php } ?>
			<?php if ($resultpage['moduleType'] == 3 && $resultlists['isFD'] != 1 && $resultlists['saveQuotaiton'] == 1) { ?>
			<td align="right">
				<a onClick="alertspopupopen('action=fixDepHotelAvailability&queryId=<?php echo $_REQUEST['id']; ?>','840px','auto');">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;">Hotel&nbsp;Availability</div>
				</a>
			</td>
			<?php } ?>
			<?php if ($resultpage['moduleType'] == 4 && $resultlists['isPackage'] == 1) { ?>
			<td align="right">
				<a onClick="alertspopupopen('action=packageHotelAvailability&queryId=<?php echo $_REQUEST['id']; ?>','840px','auto');">
					<div class="saveasbtn" style="border-radius: 4px !important;color: #ffffff !important;background-color: #0c0c0c !important;margin-right: 5px;">Hotel&nbsp;Availability</div>
				</a>
			</td>
			<?php } ?>
			<!-- preview File -->
			<td width="8%" align="left">
			<?php if($queryTypeId!=13) { ?>
					<a href="<?php echo $fullurl; ?>PreviewFiles/crm_proposal.php?propNum=<?php if($resultlists['quotationType']==2){ echo "6"; }else{ echo "6";} ?>&q_token=<?php echo trim($resultlists['q_token']);?>&id=<?php echo encode($resultlists['id']);?>" target="_blank">
						<div class="saveasbtn" style="margin-right: 5px;">Preview</div>
					</a>
					<?php } ?>
			</td>
			<?php if (($resultpage['moduleType'] == 2 && $resultlists['isSeries'] == 1) || ($resultpage['moduleType'] == 3 && $resultlists['isFD'] == 1)) { ?>
			<td colspan="2"></td>
				<?php } ?>
			<?php if ($resultpage['moduleType'] == 1) { ?>
			<td width="9%" align="left">
				<?php if ($resultlists['status'] == 1) { ?>
				<div class="saveasbtn" style="margin-right: 5px; color: #fff !important; border: 1px #e17c00 solid !important; background-color: #e17c00 !important;" onClick="alertspopupopen('action=finalquote&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultlists['id']; ?>','1000px','auto');">FinalQuot.</div>
				<?php } else {
				if($queryTypeId!=13) { ?>
				<div class="saveasbtn aleart2" style="margin-right: 5px;" id="<?php echo encode($resultlists['id']); ?>">Duplicate</div>
				<?php }
				} ?>
			</td>
			<?php } ?>
				<?php if ($resultpage['moduleType'] == 1 && $resultpage['queryType'] != 4) { ?>
				<td align="right">
				<?php if($queryTypeId!=13) { ?>
					<a onClick="alertspopupopen('action=queryHotelAvailability&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo encode($resultlists['id']); ?>','1050px','auto');">
						<div class="saveasbtn" style="margin-right: 5px;">Hotel&nbsp;Availabilty</div>
					</a>
					<?php } ?>
				</td>
				<?php } ?>
				<?php if ($resultpage['moduleType'] == 1) { ?>
				<td width="10%" align="left">
				<?php
				if ($resultlists['status'] == 2 && mysqli_num_rows($haveFinalQuery) > 0) { ?>
					<!--href="frmaction.php?action=selectedquotations&status=0&queryid=<?php echo $resultpage['id']; ?>&id=<?php echo ($resultlists['id']); ?>"-->
					<a><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 30px;"></i></a>
					<?php
				}
				
				if (mysqli_num_rows($haveFinalQuery) < 1) {
					$rsp2 = GetPageRecord('*', 'quotationHotelMaster', 'quotationId=' . $resultlists['id'] . ' and isHotelSupplement=1');
					$rsp3 = GetPageRecord('*', 'quotationAdditionalMaster', 'quotationId=' . $resultlists['id'] . ' ');
					$rsp4 = GetPageRecord('*', 'quotationHotelMaster', ' 1 and supplierId in ( select supplierId from quotationRoomSupplimentMaster where 1 and quotationId="' . $resultlists['id'] . '" ) and quotationId="' . $resultlists['id'] . '" ');
					if ($resultlists['quotationType'] == 1) { ?>
						<a <?php if ($resultpage['queryStatus'] != 3) { ?> onClick="alertspopupopen('action=chooseSupplimentServices&status=1&queryId=<?php echo $resultpage['id']; ?>&quotationId=<?php echo $resultlists['id']; ?>','800px','auto');" <?php } ?> class="saveasbtn2">Make&nbsp;Final</a>
						<?php
					} else { ?>
						<a <?php if ($resultpage['queryStatus'] != 3) { ?> onClick="alertspopupopen('action=finalQuotation&status=1&queryId=<?php echo $resultpage['id']; ?>&id=<?php echo $resultlists['id']; ?>','600px','auto');" <?php } ?> class="saveasbtn2">Make&nbsp;Final</a>
						<?php
					}
				}
				?>
			</td>
			<!-- Agent payment request -->
			<?php } ?>
			<?php if ($resultpage['moduleType'] == 1) { ?>
			<td width="17%" align="left"><?php
				if ($resultlists['isPaymentRequest'] == 1 && $resultlists['status'] == 1) {
					$result = mysqli_query(db(), "select * from " . _PAYMENT_REQUEST_MASTER_ . " where queryid='" . $resultpage['id'] . "' and quotationId='" . $resultlists['id'] . "' and deletestatus!=1")  or die(mysqli_error(db()));
					$number = mysqli_num_rows($result);
					$getpaymentid = mysqli_fetch_array($result);
					if ($number > 0) {
						$rsasd = GetPageRecord('id', _PAYMENT_REQUEST_MASTER_, 'queryid=' . $resultpage['id'] . ' and quotationId=' . $resultlists['id'] . '');
						$resultpaymentpage = mysqli_fetch_array($rsasd);
					?><a style="color: #e87e11 !important; font-weight: 500; border: 1px solid #4CAF50; padding: 5px; border-radius: 3px; background-color: #ffff;" href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo  encode($resultpaymentpage['id']); ?>&QueryId=<?php echo $resultpage['id']; ?>">Payment&nbsp;Info.</a>
				<?php
				} else {
				?>
				<a style="color: #e87e11 !important; font-weight: 500; border: 1px solid #4CAF50; padding: 5px; border-radius: 3px; background-color: #ffff;" href="frm_action.crm?addpaymentrequest=1&quotationId=<?php echo ($resultlists['id']); ?>&QueryId=<?php echo ($resultpage['id']); ?>">Payment&nbsp;Info.</a>
				<?php
					}
				}
				?>
			</td>
			<?php } ?>
			<style>
				.btnstatus {
					border-radius: 7px;
					background-color: #4CAF50;
					border: solid 0px;
					color: #fff;
					padding: 4px 10px;
					outline: 0px;
					width: 63px;
				}
				.saveasbtn2 {
					border: 1px #17651a solid !important;
					padding: 5px !important;
					border-radius: 2px !important;
					color: #17651a !important;
					background-color: #d3fdc9 !important;
					cursor: pointer;
					font-weight: 500;
					float: left;
					width: auto !important;
					font-size: 12px;
				}
			</style>
			<?php
			$packageId = $resultlists['id'];
			$selectp = '*';
			$wherep = ' packageId="' . $packageId . '" ';
			$rsp = GetPageRecord($selectp, _PACKAGE_BUILDER_PRICE_LIST, $wherep);
			$packagedetails = mysqli_fetch_array($rsp);
			?>
		</tr>
		<?php $no++;
			$qn++;
		} ?>
	</tbody>
	</table>
	<style>
		.gridtable td {
			padding: 3px !important;
		    border: 1px solid #e4e4e4;
		    background-color: #ffffff;
		}
	</style>
	<div id="savasquotation" style="display:none;"></div>
	<script>
		$(document).ready(function() {
			$('.aleart2').click(function(){
				let queryStatus = '<?php echo $resultpage['queryStatus']; ?>';
				if(queryStatus=='3'){
					alert('You can not make this query duplicate, Because you have finalized it.')
				}else{
				var id = $(this).attr('id');
				var conf = confirm('Sure want to Save as New..?');
				if (conf == true){
			$('#savasquotation').load('loadB2bSaveQuotation.php?id=' + id + '&queryid=<?php echo $_GET['id']; ?>');
			}
		}
		});
	
		});
	//setTimeout(function(){ }, 2000);
	</script>
	<?php if ($g != 1) { ?>
	<div style="padding:20px; text-align:center;">
	<?php if ($resultpage['moduleType'] == 1) { ?>No Quotation <?php }
	if ($resultpage['moduleType'] == 2) { ?> No Series <?php }
	if ($resultpage['moduleType'] == 3) { ?> No Fixed Departure <?php } ?>
	</div>
	<?php }  ?>
	</div>
	<?php } ?>
	<?php if ($_REQUEST['tourextension'] == 1) { ?>
	<div style="padding:15px;">
	<table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablesorter gridtable">
	<thead>
		<tr width="100%">
			<th width="15%" align="left" class="header">
				<div align="left">Quotation&nbsp;Id</div>
			</th>
			<th width="15%" align="left" class="header">
				<div align="left">Tour Type</div>
			</th>
			<th width="30%" align="left" class="header">
				<div align="left">Travel&nbsp;Date</div>
			</th>
			<th width="10%" align="left" class="header">
				<div align="left">Duration</div>
			</th>
			<th colspan="2" width="30%" align="center" class="header">
				<div align="center">Action</div>
			</th>
		</tr>
	</thead>
	<tbody>
		<style>
			.saveasbtn {
				border: 1px #cecece solid !important;
				padding: 5px !important;
				border-radius: 2px !important;
				color: #3c3c3c !important;
				background-color: #dcdcdc !important;
				cursor: pointer;
				font-weight: 500;
				float: left;
				width: auto !important;
				font-size: 12px;
			}
		</style>
		<?php
		$no = 1;
		$qn = 0;
		$select = '*';
		$where = '';
		$rs = '';
		$wheresearch = '';
		$limit = clean($_GET['records']);
		$searchField = clean(trim(ltrim($_GET['searchField'], '0')));
		// delete unneccessory entries
		//$sql_del = "delete from quotationMaster where fromDate < '".date('Y-m-d')."'";
		//mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
		$where = 'where isTourEx=1 and deletestatus=0 and queryId="' . $resultpage['id'] . '" order by id asc';
		$page = $_GET['page'];
		$targetpage = $fullurl . 'showpage.crm?module=quotations&records=' . $limit . '&searchField=' . $searchField . '&';
		$rs = GetRecordList($select, _QUOTATION_MASTER_, $where, $limit, $page, $targetpage);
		$totalentry = $rs[1];
		$paging = $rs[2];
		while ($resultQuery = mysqli_fetch_array($rs[0])) {
			$rsp = GetPageRecord('*', 'newQuotationDays', 'quotationId=' . $resultQuery['id'] . '');
			$counthot = mysqli_num_rows($rsp);
			$char = range('A', 'Z');
			$g = '1';
			$makeQueryId = makeExtensionId($resultpage['displayId']) . "-" . $resultQuery['quotationNo'];
			$updatelist = updatelisting(_QUOTATION_MASTER_, 'quotationNo="' . $char[$qn] . '"', 'id="' . $resultQuery['id'] . '"');
		?>
		<tr <?php if ($resultQuery['lostStatus'] == 1) { ?> style="background-color: #b46767; border: 3px solid #b46767; color: #ffffff !important;" <?php }
			if ($resultQuery['status'] == 1) { ?> style="background-color: #deffe0; border: 3px solid #6cc791;" <?php } ?>>
			<td>
				<div align="left"><a <?php if ($resultQuery['lostStatus'] == 1) { ?> style="color: #ffffff;" <?php } else { ?> href="showpage.crm?module=quotations&view=yes&id=<?php echo encode($resultQuery['id']); ?>&tourextension=1" <?php } ?>><?php echo $makeQueryId;  ?></a></div>
			</td>
			<td>
				<div align="left"><?php if ($resultQuery['extensionType'] == 1) { ?> Pre Tour <?php }
				if ($resultQuery['extensionType'] == 2) { ?> Post Tour <?php } ?> </div>
			</td>
			<td>
				<div align="left"><?php echo date('d-m-Y', strtotime($resultQuery['fromDate'])); ?> To <?php echo date('d-m-Y', strtotime($resultQuery['toDate'])); ?></div>
			</td>
			<td>
				<div align="left"><?php echo $counthot; ?> Days</div>
			</td>
			<td align="left">
				<?php if ($resultQuery['quotationType'] == 2) { ?>
				<a onClick="alertspopupopen('action=selectCostSheet&quotationId=<?php echo $resultQuery['id']; ?>','300px','auto');">
					<div class="saveasbtn" style="margin-right: 5px;">Cost&nbsp;Sheet</div>
				</a>
				<?php } else { ?>
				<a onClick="alertspopupopen('action=addCostSheet&queryId=<?php echo $resultQuery['id']; ?>&quotationId=<?php echo $resultQuery['id']; ?>','1300px','auto');">
					<div class="saveasbtn" style="margin-right: 5px;">Cost&nbsp;Sheet</div>
				</a>
				<?php } ?>
			</td>
			<td width="6%" align="left" style="display:none;"> </td>
			<td width="9%" align="left"><?php if ($resultQuery['status'] == 1) { ?><div class="saveasbtn" style="margin-right: 5px; color: #fff !important; border: 1px #e17c00 solid !important; background-color: #e17c00 !important;" onClick="alertspopupopen('action=finalquote&queryId=<?php echo encode($resultQuery['id']); ?>&quotationId=<?php echo $resultQuery['id']; ?>&parentId=<?php echo encode($resultpage['id']); ?>','1000px','auto');">FinalQuot.</div><?php } ?></td>
			<td width="10%" align="center"><?php
				if ($resultQuery['status'] == 1) { ?><a href="frmaction.php?action=selectedquotations&status=0&queryid=<?php echo $resultQuery['queryId']; ?>&id=<?php echo ($resultQuery['id']); ?>&parentId=<?php echo encode($resultpage['id']); ?>"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 30px;"></i></a><?php } else {
				if ($resultQuery['quotationType'] == 1) {
				?><a href="frmaction.php?action=selectedquotations&status=1&queryid=<?php echo $resultQuery['queryId']; ?>&id=<?php echo ($resultQuery['id']); ?>&parentId=<?php echo encode($resultpage['id']); ?>&tourextension=1" class="saveasbtn2">Make&nbsp;Final</a><?php } else { ?><a onClick="alertspopupopen('action=finalQuotation&status=1&queryId=<?php echo $resultQuery['queryId']; ?>&id=<?php echo $resultQuery['id']; ?>&parentId=<?php echo encode($resultpage['id']); ?>&tourextension=1',	'300px','auto');" class="saveasbtn2">Make&nbsp;Final</a><?php }
				} ?></td>
			<td width="14%" align="left"><?php
											$result = mysqli_query(db(), "select * from " . _PAYMENT_REQUEST_MASTER_ . " where queryid='" . $resultQuery['queryId'] . "' and quotationId='" . $resultQuery['id'] . "' and deletestatus!=1")  or die(mysqli_error(db()));
											$number = mysqli_num_rows($result);
											$getpaymentid = mysqli_fetch_array($result);
											if ($number > 0) {
												$rsasd = GetPageRecord('id', _PAYMENT_REQUEST_MASTER_, 'queryid=' . $resultQuery['queryId'] . ' and quotationId="' . $resultQuery['id'] . '"');
												$resultpaymentpage = mysqli_fetch_array($rsasd);
			?><a style="color: #e87e11 !important; font-weight: 500; border: 1px solid #4CAF50; padding: 5px; border-radius: 3px; background-color: #ffff;" href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo  encode($resultpaymentpage['id']); ?>&QueryId=<?php echo $resultQuery['queryId']; ?>">Payment&nbsp;Request</a>
			<?php } else {
										if ($resultpage['quotationYes'] == 2) {
											$rsaa = GetPageRecord('status', _QUOTATION_MASTER_, 'id="' . $resultQuery['id'] . '"');
											$resultquot = mysqli_fetch_array($rsaa);
											if ($resultquot['status'] == 1) {
			?>
			<a style="color: #e87e11 !important; font-weight: 500; border: 1px solid #4CAF50; padding: 5px; border-radius: 3px; background-color: #ffff;" href="frm_action.crm?addpaymentrequest=1&QueryId=<?php echo $resultQuery['queryId']; ?>&quotationId=<?php echo ($resultQuery['id']); ?>&tourextension=1">Payment&nbsp;Request</a>
			<?php }
											}
			} ?>
		</td>
	</tr>
	<?php
	$packageId = $resultQuery['queryId'];
	$selectp = '*';
	$wherep = ' packageId="' . $packageId . '" ';
	$rsp = GetPageRecord($selectp, _PACKAGE_BUILDER_PRICE_LIST, $wherep);
	$packagedetails = mysqli_fetch_array($rsp);
	?>
	<?php $no++;
		$qn++;
	} ?>
	</tbody>
	</table>
	<style>
		.btnstatus {
			border-radius: 7px;
			background-color: #4CAF50;
			border: solid 0px;
			color: #fff;
			padding: 4px 10px;
			outline: 0px;
			width: 63px;
		}
		.saveasbtn2 {
			border: 1px #17651a solid !important;
			padding: 5px !important;
			border-radius: 2px !important;
			color: #17651a !important;
			background-color: #d3fdc9 !important;
			cursor: pointer;
			font-weight: 500;
			float: left;
			width: auto !important;
			font-size: 12px;
		}
	</style>
	<style>
		.gridtable td {
			padding: 7px 2px !important;
		}
	</style>
	<div id="savasquotation" style="display:none;"></div>
	<script>
		$(document).ready(function() {
			$('.aleart2').click(function() {
				let queryStatus = '<?php echo $resultpage['queryStatus']; ?>';
				if(queryStatus=='3'){
					alert('You can not make this query duplicate, Because you have finalized it.')
				}else{
				var id = $(this).attr('id');
				var conf = confirm('Sure want to Save as New..?');
				if (conf == true) {
	$('#savasquotation').load('loadB2bSaveQuotation.php?id=' + id + '&queryid=<?php echo $_GET['id']; ?>');
	}
}
	})
	})
	//setTimeout(function(){ }, 2000);
	</script>
	<?php if ($g != 1) { ?>
	<div style="padding:20px; text-align:center;">No Tour</div>
	<?php } ?>
	</div>
	<?php
	}
	 ?>
	<?php //if ($_REQUEST['guestlist'] == 1) { ?>
	<!-- <div style="padding:15px;">
	<div style="margin-bottom: 10px;
	padding-bottom: 10px;
	position: relative;
	font-size: 14px;
	font-weight: 500;
	border-bottom: 1px solid #ccc;">Guest Book (
	<?php
	// $select1 = '*';
	// $where1 = 'queryId=' . decode($_REQUEST['id']) . '';
	// $rs1 = GetPageRecord('id', 'guestList', $where1);
	// echo $totalguest = mysqli_num_rows($rs1);
	?>
	) <a href="<?php echo $fullurl; ?>travrmimports/guest-import-format.xls" target="_blank" style="background-color: #fff;
	color: #fff !important;
	position: absolute;
	right: 153px;
	top: -4px;
	font-size: 12px;
	padding: 5px 10px;background-color: #233a49;border-radius: 4px;">Download Import Format</a>
	<a href="#" style="background-color: #f69100;
	color: #fff !important;
	position: absolute;
	right: 85px;
	top: -5px;
	font-size: 12px;
	padding: 5px 10px;border-radius: 4px;" id="importbutton">Import</a>
	<a href="#" style="background-color:#4CAF50; color:#fff !important; position:absolute; right:0px; top:-5px; font-size:12px; padding:5px 10px;border-radius: 4px;" onClick="alertspopupopen('action=addguestbook&queryId=<?php echo $_REQUEST['id']; ?>&destinationId=<?php echo $resultpage['destinationId']; ?>','650px','auto');">Add Guest</a>
	<script>
		function submitimportfrom() {
			$('#importfrm').submit();
		}
		$('#importbutton').click(function() {
			$('#importfield').click();
		});
	</script>
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm" target="actoinfrm" style="display:none;">
	<input name="importexcelguestlist" id="importexcelguestlist" type="hidden" value="Y" />
	<input name="queryId" id="queryId" type="hidden" value="<?php echo $resultpage['id']; ?>" />
	<input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onChange="submitimportfrom();" />
	</form>
	</div>
	<div style="overflow-x: auto;max-width:1131px;" class="guestListTable">
	<?php
	// $guestListTable = '';
	// $guestListTable = '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="guestListTable tablesorter gridtable">
	// <thead>
	// 	<tr>
	// 		<th align="left" class="header">Full Name</th>
	// 		<th align="left" class="header">Age</th>
	// 		<th align="center" class="header" >Gender</th>
	// 		<th align="center" class="header" >Meal</th>
	// 		<th align="center" class="header" >Special</th>
	// 		<th align="center" class="header" ><span class="gridlable">Seat</span></th>
	// 		<th align="center" class="header" >ID&nbsp;Proof</th>
	// 		<th align="center" class="header" >Country</th>
	// 		<th align="center" class="header" >Address&nbsp;Proof</th>
	// 		<th align="center" class="header" >Passport</th>
	// 		<th align="center" class="header" >Visa</th>
	// 		<th align="left" class="header" >Action</th>
	// 	</tr>
	// </thead>


	// <tbody>';
	// 	$where = 'queryId = "' . $resultpage['id'] . '" order by id asc';
	// 	$rs = GetPageRecord($select, 'guestList', $where);
	// 	while ($resListing = mysqli_fetch_array($rs)) {
	// 		$guestListTable .= '<tr>';
	// 			$guestListTable .= '<td align="left" style="padding-left:0px;">' . stripslashes($resListing['title']) . ' ' . stripslashes($resListing['fname']) . ' ' . stripslashes($resListing['lname']) . '</td>';
	// 			$guestListTable .= '<td align="left" style="padding-left:0px;"><a href="mailto:' . $resListing['age'] . '">' . stripslashes($resListing['age']) . 'Y</a></td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">' . stripslashes($resListing['gender']) . '</td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">';
	// 				$abc = GetPageRecord('*', 'mealPreference', 'id="' . $resListing['mealPreference'] . '"');
	// 				$abcpre = mysqli_fetch_array($abc);
	// 				$guestListTable .= $abcpre['name'];
	// 				if ($abcpre['id'] == '') {
	// 					$guestListTable .= $resListing['mealPreference'];
	// 				}
	// 			$guestListTable .= '</td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">';
	// 				// echo stripslashes($resListing['physicalCondition']);
	// 				$abc = GetPageRecord('*', 'physicalCondition', 'id="' . $resListing['physicalCondition'] . '"');
	// 				$abcpre1 = mysqli_fetch_array($abc);
	// 				$guestListTable .= $abcpre1['name'];
	// 				if ($abcpre1['id'] == '') {
	// 					$guestListTable .= $resListing['special_assist'];
	// 				}
	// 			$guestListTable .= '</td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">' . stripslashes($resListing['seatPreference']) . '</td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">';
	// 				$where1 = 'queryId=' . $resListing['queryId'] . ' and guestId=' . $resListing['id'] . ' and documentType="ID Proof"';
	// 				$rs1 = GetPageRecord('*', 'guestListDocuments', $where1);
	// 				$querydata = mysqli_fetch_array($rs1);
	// 				if ($querydata['id'] != '') {
	// 					$guestListTable .= '<span class="greentabsss">Yes</span>';
	// 				} else {
	// 					$guestListTable .= 'No';
	// 				}
	// 			$guestListTable .= '</td>';
	// 			$guestListTable .= '<td align="left" class="iconsfa">';
	// 				$countryId = $resListing['countryId'];
	// 				$where1 = ' id ="' . $countryId . '" ';
	// 				$rs1 = GetPageRecord('name', 'countryMaster', $where1);
	// 				$querydata = mysqli_fetch_array($rs1);
	// 				$guestListTable .= $querydata['name'];
	// 			$guestListTable .= '</td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">';
	// 				$where1 = 'queryId=' . $resListing['queryId'] . ' and guestId=' . $resListing['id'] . ' and documentType="Address Proof"';
	// 				$rs1 = GetPageRecord('*', 'guestListDocuments', $where1);
	// 				$querydata = mysqli_fetch_array($rs1);
	// 				if ($querydata['id'] != '') {
	// 					$guestListTable .= '<span class="greentabsss">Yes</span>';
	// 				} else {
	// 					$guestListTable .= 'No';
	// 				}
	// 			$guestListTable .= '</td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">';
	// 				$where1 = 'queryId=' . $resListing['queryId'] . ' and guestId=' . $resListing['id'] . ' and documentType="Passport"';
	// 				$rs1 = GetPageRecord('*', 'guestListDocuments', $where1);
	// 				$querydata = mysqli_fetch_array($rs1);
	// 				if ($querydata['id'] != '') {
	// 					$guestListTable .= '<span class="greentabsss">Yes</span>';
	// 				} else {
	// 					$guestListTable .= 'No';
	// 				}
	// 			$guestListTable .= '</td>';
	// 			$guestListTable .= '<td align="center"  class="iconsfa">';
	// 				$where1 = 'queryId=' . $resListing['queryId'] . ' and guestId=' . $resListing['id'] . ' and documentType="Visa"';
	// 				$rs1 = GetPageRecord('*', 'guestListDocuments', $where1);
	// 				$querydata = mysqli_fetch_array($rs1);
	// 				if ($querydata['id'] != '') {
	// 					$guestListTable .= '<span class="greentabsss">Yes</span>';
	// 				} else {
	// 					$guestListTable .= 'No';
	// 				}
	// 			$guestListTable .= '</td>';
	// 			$guestListTable .= '<td align="left" class="iconsfa"><div style="width:80px;">';
	// 				$nameOutput = str_replace(' ', '&nbsp;', $resListing['name']);
	// 				// $guestListTable.='<i class="fa fa-file-text"  title="Documents" style="cursor:pointer; color:#05a3be;" onClick="alertspopupopen(`action=addguestdocuments&queryId='.$_REQUEST['id'].'&id='.$resListing['id'].'&name='.$nameOutput.'`,`550px`,`auto`);"></i>';
	// 			$guestListTable .= '<i class="fa fa-pencil"  title="Edit" style="cursor:pointer; color:#FF6600;" onClick="alertspopupopen(`action=addguestbook&queryId=' . $_REQUEST['id'] . '&destinationId=' . $resultpage['destinationId'] . '&id=' . $resListing['id'] . '`,`650px`,`auto`);"></i></div></td>';
	// 		$guestListTable .= '</tr>';
	// 		$no++;
	// 	}
	// $guestListTable .= '</tbody></table>';
	// echo $guestListTable;
	?>
	</div>
	<form method="post" action="allReports/xlReoprtDownload.php" target="actoinfrm">
	<input type="hidden" name="output" value="<? //base64_encode($guestListTable) ?>">
	<input type="hidden" name="filename" value="Guest List">
	<input type="submit" id="guestListXl" name="export" class="bluembutton" value="Download Report">
	</form>
	</div>
	<script>
		$("#guestListXl").hide();
		$("#downloadGuestList").click(function(e) {
			e.preventDefault();
			$("#guestListXl").trigger("click");
		});
	</script>
	<style>
		.iconsfa .fa {
			font-size: 16px;
			color: #438a36;
			margin: 0px 5px;
		}
	</style>
	<?php //} ?>
	</td> -->

	
	<?php if ($resultpage['moduleType'] == 1) { ?>
	<td width="25%" align="left" valign="top" class="queryright">
	<div style="margin-top: 55px;" id="rightquerylink">
	<a href="#" onClick="myFunctionLinks()" class="dropbtn"><i id="PlusMinus" class="fa fa-plus-square dropbtn" aria-hidden="true" style="color:#82b767;"></i>Important&nbsp;Links</a>
	<a href="#" onClick="myFunction111()" class="dropbtn"><i id="PlusMinus2" class="fa fa-plus-square dropbtn" aria-hidden="true" style="color:#82b767;"></i>Payment&nbsp;Information</a>

	<div id="myDropdown11" class="dropdown-content" style="min-width: 211px;border-left: 5px solid #82b767;">
	<a href="#" onClick="alertspopupopen('action=expenseMaster&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultpageQuotation['id']; ?>','1000px','auto');"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Expense Entry </a> 
	<?php
	$result = mysqli_query(db(), "select * from " . _PAYMENT_REQUEST_MASTER_ . " where queryid='" . $resultpage['id'] . "' and deletestatus!=1")  or die(mysqli_error(db()));
	$number = mysqli_num_rows($result);
	$getpaymentid = mysqli_fetch_array($result);
	if ($number > 0) {
	?><a href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo  encode($getpaymentid['id']); ?>"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Supplier Payment </a>
	<?php 	} else {
	if ($resultpage['quotationYes'] == 0) {
	?>
	<a href="frm_action.crm?addpaymentrequest=1&QueryId=<?php echo ($resultpage['id']); ?>"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Supplier Payment</a>
	<?php
	}
	if ($resultpage['quotationYes'] == 1) {
	?>
	<a onClick="alertspopupopen('action=selectQuotationPackage&queryId=<?php echo $_GET['id']; ?>','450px','auto');"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Supplier Payment</a>
	<?php } ?>
	<?php
	if ($resultpage['quotationYes'] == 2) {
		if ($resultpageQuotation['status'] == 1) {
	?>
	<a href="frm_action.crm?addpaymentrequest=1&QueryId=<?php echo ($resultpage['id']); ?>&quotationId=<?php echo ($resultpageQuotation['id']); ?>"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Supplier Payment</a>
	<?php }
		}
	} ?>

	<?php
	$result = mysqli_query(db(), "select * from " . _PAYMENT_REQUEST_MASTER_ . " where queryid='" . $resultpage['id'] . "' and deletestatus!=1")  or die(mysqli_error(db()));
	$number = mysqli_num_rows($result);
	$getpaymentid = mysqli_fetch_array($result);
	if ($number > 0) {
	?>
	<a href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo  encode($getpaymentid['id']); ?>&dmc=1"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Client Payment </a>
	<?php
	} else {
	if ($resultpage['quotationYes'] == 0) {
	?>
	<a href="frm_action.crm?addpaymentrequest=1&QueryId=<?php echo ($resultpage['id']); ?>&quotationId=<?php echo ($resultpageQuotation['id']); ?>"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Client Request</a>
	<?php
	}
	if ($resultpage['quotationYes'] == 1) {
	?>
	<a onClick="alertspopupopen('action=selectQuotationPackage&queryId=<?php echo $_GET['id']; ?>','450px','auto');"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Client Payment </a>
	<?php } ?>
	<?php
	if ($resultpage['quotationYes'] == 2) {
		if ($resultpageQuotation['status'] == 1) {
	?>
	<a href="frm_action.crm?addpaymentrequest=1&QueryId=<?php echo ($resultpage['id']); ?>&quotationId=<?php echo ($resultpageQuotation['id']); ?>&dmc=1"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>Client Payment </a>
	<?php }
		}
		
	}
	
	?>
	


<!-- Expense entry code ended -->

	<?php
	if ($viewinvoice == 1) {
		if ($resultInvoice['quotationId'] == 0) {
			$quotationDataq = '0';
		} else {
			$quotationDataq = trim($resultpageQuotation['id']);
		}
		$invQuery = GetPageRecord('*', _INVOICE_MASTER_, 'queryId="' . $resultpage['id'] . '" and quotationId="' . $quotationDataq . '" and deletestatus=0 ');
		$invoiceCount = mysqli_num_rows($invQuery);
		$invoicepdf = mysqli_fetch_array($invQuery);
	if ($invoicepdf['docName'] != '') { ?>
	<a href="dirfiles/<?php echo $invoicepdf['docName']; ?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> View Invoice</a>
	<?php } else { ?>
	<a href="tcpdf/examples/getpdf.php?pageurl=<?php echo $fullurl; ?>invoicepdf.php?id=<?php echo encode($invoicepdf['id']); ?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> View Invoice</a>
	<?php
		}
	} ?>
	</div>
	<style>
		.dropdown {
			position: relative;
			display: inline-block;
		}
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			overflow: auto;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
		}
		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}
		.dropdown a:hover {
			background-color: #ddd;
		}
		.show {
			display: block;
		}
	</style>
	<script>
		/* When the user clicks on the button,
	toggle between hiding and showing the dropdown content */
		function myFunction111() {
			document.getElementById("myDropdown11").classList.toggle("show");
			document.getElementById("PlusMinus2").classList.toggle("fa-minus-square");
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
	<a href="#" onClick="myFunction222()" class="dropbtn"><i id="PlusMinus3" class="fa fa-plus-square dropbtn" aria-hidden="true" style="color:#82b767;"></i>Query&nbsp;Information</a>
	<div id="myDropdown33" class="dropdown-content" style="min-width: 211px;border-left: 5px solid #82b767;">
	<?php if ($resultpage['quotationYes'] != 1 && $resultpage['quotationYes'] != 2) { ?>
	<a href="<?php echo $fullurl; ?>packageQueryhtml.php?id=<?php echo encode($resultpage['id']); ?>&downloadpackage=1&servicePrice=1" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>Download Itinerary</a><a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Itinerary: <?php echo $fullurl; ?>doc/<?php echo $resultpage['id']; ?>/3.html&source=&data=" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i>Share Itinerary</a><?php } ?>
	<!-- <a href="<?php echo $fullurl; ?>showpage.crm?module=query&edit=yes&id=<?php echo $_GET['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Query</a> -->
	<a onClick="alertspopupopen('action=cancelqueryopenbox&queryId=<?php echo $_GET['id']; ?>','450px','auto');"><i class="fa fa-times-circle-o" aria-hidden="true" style="color:#cc0000;"></i> Cancel Query</a>
	<a title="Query History" onClick="alertspopupopen('action=querystatushistory&queryId=<?php echo $resultpage['id']; ?>&subject=<?php echo encode($resultpage['subject']); ?>','550px','auto');"><i class="fa fa-history" aria-hidden="true"></i> Query History</a>
	</div>
	<style>
		.dropdown {
			position: relative;
			display: inline-block;
		}
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			overflow: auto;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
		}
		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}
		.dropdown a:hover {
			background-color: #ddd;
		}
		.show {
			display: block;
		}
	</style>
	<script>
		/* When the user clicks on the button,
	toggle between hiding and showing the dropdown content */
		function myFunction222() {
			document.getElementById("myDropdown33").classList.toggle("show");
			document.getElementById("PlusMinus3").classList.toggle("fa-minus-square");
		}
		function myFunctionLinks() {
			document.getElementById("Links").classList.toggle("show");
			document.getElementById("PlusMinus").classList.toggle("fa-minus-square");
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
	<a href="#" onClick="myFunction444()" class="dropbtn"><i id="PlusMinus4" class="fa fa-plus-square dropbtn" aria-hidden="true" style="color:#82b767;"></i>Supplier&nbsp;Information</a>
	<div id="myDropdown444" class="dropdown-content" style="min-width: 211px;border-left: 5px solid #82b767;">
	<?php if ($resultpage['quotationYes'] != 1 && $resultpage['quotationYes'] != 2) { ?>
	<a href="<?php echo $fullurl; ?>packageQueryhtml.php?id=<?php echo encode($resultpage['id']); ?>&downloadpackage=1&servicePrice=1" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>Download Itinerary</a><a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Itinerary: <?php echo $fullurl; ?>doc/<?php echo $resultpage['id']; ?>/3.html&source=&data=" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i>Share Itinerary</a>
	<?php } if($queryTypeId!=13){ ?> 
	<div onmouseover="myFunction555();" onmouseleave="myFunction666();">
		<a href="javascript:void(0)"><i class="fa fa-pencil" aria-hidden="true"></i>Supplier Voucher</a>
		<ul id="supplierinfo" style="display: none;position: absolute;list-style: none;z-index: 9;padding-inline-start:0px;width: 100%;margin:0;left: 0;box-shadow: 2px 3px 9px 1px #bea8a8;">
			<?php
			$resultq = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId="'.decode($_GET['id']).'" and isTourEx=0 and status=1');
			while ($resultDataq = mysqli_fetch_array($resultq)) { ?>
			<li style="background-color:#fff"><a style="padding: 10px" href="showpage.crm?module=SupplierVoucher&qid=<?php echo encode($resultDataq['id']); ?>&queryId=<?php echo $_GET['id']; ?>" target="_blank"><?php echo makeQuotationId($resultDataq['id']) . ' | Final'; ?></a></li>
			<?php }
			$qnc = '0';
			$resultq = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId="' . decode($_GET['id']) . '" and isTourEx=1');
			while ($resultDataq = mysqli_fetch_array($resultq)) { ?>
			<li style="background-color:#fff"><a style="padding: 10px" href="showpage.crm?module=SupplierVoucher&qid=<?php echo encode($resultDataq['id']); ?>&queryId=<?php echo $_GET['id']; ?>" target="_blank">
				<?php if ($resultDataq['isTourEx'] == 1) {
					$charc = range('A', 'Z');
					$makeQueryId = makeExtensionId($resultpage['displayId']) . "-" . $charc[$qnc];
					echo $makeQueryId;
				?>
				<?php } ?>
			</a></li>
			<?php $qnc++;
			} ?>
		</ul>
	</div>
	<?php } ?>
	<script type="text/javascript">
		function myFunction555() {
			$('#supplierinfo').show()
		}
		function myFunction666() {
			$('#supplierinfo').hide()
		}
	</script>
	<a href="#" onClick="alertspopupopen('action=finalquote&status=1&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultpageQuotation['id']; ?>','1000px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Supplier Confirmation</a>
	<a href="#" onClick="alertspopupopen('action=travelArrangementNew&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultpageQuotation['id']; ?>','800px','auto');"><i class="fa fa-file-text" aria-hidden="true"></i> Travel&nbsp;Arrangement&nbsp;List</a>
	<a href="#" onClick="alertspopupopen('action=roominglist&queryId=<?php echo $_REQUEST['id']; ?>&quotationId=<?php echo $resultpageQuotation['id']; ?>','1200px','auto');"><i class="fa fa-file-text" aria-hidden="true"></i>Hotel Rooming List</a>
	</div>
	<div id="Links" class="dropdown-content" style="min-width: 211px;border-left: 5px solid #82b767;position:absolute;top:92px;">
	<a href="https://www.irctc.co.in/eticketing/forgotPasswordSuccess.jsf" target="_blank">irctc.com</a>
	<a href="https://www.makemytrip.com/" target="_blank">makemytrip.com</a>
	<a href="https://www.booking.com/" target="_blank">Booking.com</a>
	<a href="https://www.cleartrip.com" target="_blank"> cleartrip.com</a>
	<?php /*?> <a href="<?php echo $fullurl; ?>showpage.crm?module=toures"><i class="fa fa-file-text" aria-hidden="true"></i>Select Tour manager</a><?php */ ?>
	<a href="https://in.hotels.com/co10233076-qu0/cheap-hotels-in-india/" target="_blank">Hotels.com</a>
	</div>
	<style>
		.dropdown {
			position: relative;
			display: inline-block;
		}
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			overflow: auto;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
		}
		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}
		.dropdown a:hover {
			background-color: #ddd;
		}
		.show {
			display: block;
		}
	</style>
	<script>
		/* When the user clicks on the button,
	toggle between hiding and showing the dropdown content */
		function myFunction444() {
			document.getElementById("myDropdown444").classList.toggle("show");
			document.getElementById("PlusMinus4").classList.toggle("fa-minus-square");
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
	<a href="#" onClick="myFunction3333()" class="dropbtn"><i id="PlusMinus5" class="fa fa-plus-square dropbtn" aria-hidden="true" style="color:#82b767;"></i>TO DO LIST</a>
	<div id="myDropdown33333" class="dropdown-content" style="min-width: 211px;border-left: 5px solid #82b767;">
		<?php if ($resultpage['quotationYes'] != 1 && $resultpage['quotationYes'] != 2) { ?>
		<?php } ?>
		<!-- <a href="<?php echo $fullurl; ?>showpage.crm?module=checklist&view=yes&id=<?php echo $_GET['id']; ?>"><i class="fa fa-file-text" aria-hidden="true"></i> Check List</a> -->
		<a href="<?php echo $fullurl; ?>showpage.crm?module=todolist&view=yes&id=<?php echo $_GET['id']; ?>"><i class="fa fa-file-text" aria-hidden="true"></i>To&nbsp;Do&nbsp;List</a>
		<?php if($resultpageQuotation['status']==1){ ?>
		<!-- <a href="tcpdf/examples/getpdf.php?download=1&savetoserver=1&pageurl=<?php echo $fullurl;  ?>inbound_tourcard.php?id=<?php //echo encode($resultpageQuotation['id']); ?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Tour&nbsp;Card</a>
		<a href="tcpdf/examples/getpdf.php?download=1&savetoserver=1&pageurl=<?php echo $fullurl;  ?>inbound_tourstatus.php?id=<?php //echo encode($resultpageQuotation['id']); ?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Tour&nbsp;Status</a> -->
		<?php } ?>

		<a href="#" onClick="alertspopupopen('action=tourdetails&queryId=<?php echo decode($_GET['id']); ?>&tourManager=<?= $resultpage['tourManager'] ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Assign Tour manager</a>
		<!-- <a href="<?php echo $fullurl; ?>showpage.crm?module=toures"><i class="fa fa-file-text" aria-hidden="true"></i>Select Tour manager</a> -->
	</div>
	<style>
		.dropdown {
			position: relative;
			display: inline-block;
		}
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			overflow: auto;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
		}
		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}
		.dropdown a:hover {
			background-color: #ddd;
		}
		.show {
			display: block;
		}
	</style>
	<script>
		/* When the user clicks on the button,
	toggle between hiding and showing the dropdown content */
		function myFunction3333() {
			document.getElementById("myDropdown33333").classList.toggle("show");
			document.getElementById("PlusMinus5").classList.toggle("fa-minus-square");
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
	<?php //if($resultpage['queryStatus']==1 || $resultpage['queryStatus']==2  || $resultpage['queryStatus']==6 || $resultpage['queryStatus']==7){
	?>
	<!--<a onclick="alertspopupopen('action=queryclose&queryId=<?php echo $_GET['id']; ?>','450px','auto');"><i class="fa fa-info-circle" aria-hidden="true"></i> Change Status</a>--><?php //}
	?>
	<?php if ($resultpage['queryStatus'] == 3) { ?>
	<?php
	$select111i = '*';
	$where111i = 'queryId=' . $resultpage['id'] . ' and deletestatus=0 ';
	$rs111i = GetPageRecord($select111i, _INVOICE_MASTER_, $where111i);
	$invoiceCount = mysqli_num_rows($rs111i);
	$invoicepdf = mysqli_fetch_array($rs111i);
	?>
	<?php
	$select = '';
	$where = '';
	$rs = '';
	$select = '*';
	$where = '  queryId="' . $resultpage['id'] . '" ';
	$rs = GetPageRecord($select, _DMC_PAYMENT_REQUEST_, $where);
	while ($resListing = mysqli_fetch_array($rs)) {
		$curid = $resListing['currencyId'];
		$t = 0;
		$select4 = '';
		$where4 = '';
		$rs4 = '';
		$select4 = 'sum(subtotal) as TotaladultCost';
		$where4 = 'queryId="' . $resultpage['id'] . '" ';
		$rs4 = GetPageRecord($select4, _DMC_PAYMENT_REQUEST_, $where4);
		while ($adultcostSightseeingcost = mysqli_fetch_array($rs4)) {
			$t = $adultcostSightseeingcost['TotaladultCost'];
			$select3 = 'sum(amount) as TotaladultCost';
			$where3 = 'queryId=' . $resultpage['id'] . '';
			$rs3 = GetPageRecord($select3, _DMC_PAYMENT_LIST_MASTER_, $where3);
			while ($curname = mysqli_fetch_array($rs3)) {
				$reciveAmount = $curname['TotaladultCost'];
			}
			$diffrence = $t - $reciveAmount;
		}
	}
	if ($diffrence > 0) {
		$select = '*';
		$where = 'queryid=' . $resultpage['id'] . '';
		$rs = GetPageRecord($select, _PAYMENT_REQUEST_MASTER_, $where);
		$count = mysqli_num_rows($rs);
		if ($count > 0) {
			$resultpaymentpage = mysqli_fetch_array($rs);
			$lastid = $resultpaymentpage['id'];
		}
	?>
	<a href="showpage.crm?module=paymentrequest&view=yes&id=<?php echo encode($lastid); ?>&dmc=1" class="activewhite<?php if ($_REQUEST['dmc'] == 1) { ?> activey<?php } ?>"><i class="fa fa-credit-card" aria-hidden="true" style="color:#b51515;"></i>Client Payment (Unpaid)</a>
	<?php } ?>
	<?php
	$result = mysqli_query(db(), "select * from " . _PAYMENT_REQUEST_MASTER_ . " where queryid='" . $resultpage['id'] . "' ")  or die(mysqli_error(db()));
	$number = mysqli_num_rows($result);
	$getpaymentid = mysqli_fetch_array($result);
	if ($number > 0) {
		$result = mysqli_query(db(), "select * from " . _VOUCHER_MASTER_ . " where queryId='" . $resultpage['id'] . "' and deletestatus!=1")  or die(mysqli_error(db()));
		$number = mysqli_num_rows($result);
		if ($number > 0) {
			$select = '';
			$where = '';
			$rs = '';
			$select = '*';
			$where = 'queryId=' . $resultpage['id'] . ' order by id desc';
			$rs = GetPageRecord($select, _VOUCHER_MASTER_, $where);
			$resultvou = mysqli_fetch_array($rs);
	?>
	<?php } else { ?> <a href="frm_action.crm?addvoucher=1&QueryId=<?php echo $resultpage['id']; ?>" target="actoinfrm" style="display:none;"><i class="fa fa-plus-square" aria-hidden="true" style="color:#82b767;"></i> Genrate Voucher</a>
	<?php }
	} ?>
	<?php
	if ($invoiceCount > 0) {
	} else {
	if ($resultpage['queryStatus'] == 3) { ?>
	<!--	<a onclick="alertspopupopen('action=adduploadinvoice&QueryId=<?php echo makeQueryId($resultpage['id']); ?>&addinvoice=1','300px','auto');" href="#" ><i class="fa fa-plus-square" aria-hidden="true"  style="color:#82b767;"></i> Create Invoice</a>-->
	<?php
		}
	} ?>
	<input name="cancelwithvoucher" id="cancelwithvoucher" type="hidden" value="0" /><?php } ?>
	<script>
		function gocancelquery() {
			var cancelwithvoucher = $('#cancelwithvoucher').val();
	window.location.href = 'showpage.crm?module=query&view=yes&id=<?php echo $_GET['id']; ?>&status=20&cancelwithvoucher=' + cancelwithvoucher + '';
	}
	</script>


<!-- Assign Query Started  -->
	<a href="#" onClick="myFunction55555()" class="dropbtn"><i id="PlusMinus6" class="fa fa-plus-square dropbtn" aria-hidden="true" style="color:#82b767;"></i>ASSIGN QUERY</a>

	<div id="myDropdown55555" class="dropdown-content" style="min-width: 310px;border-left: 5px solid #82b767;">
		<?php if ($resultpage['quotationYes'] != 1 && $resultpage['quotationYes'] != 2) { ?>
		<?php } ?>
		
		<a onclick="alertspopupopen('action=assignafterconfirmation&queryId=<?php echo $_GET['id']; ?>&assignTo=<?php echo $resultpage['assignTo']; ?>','450px','auto');"><i class="fa fa-pencil dropbtn" aria-hidden="true" style="color:#82b767; cursor:pointer;"></i>Assign&nbsp;Query-OPS. <?php if ($resultpage['assignTo']!= 0) { ?> <span style="position: absolute; top: 6px; margin-left: 10px; background-color: #7a96ff; color: #fff; padding: 5px 10px; font-size: 11px; border-radius: 4px; text-align: center;"><?php echo getUserName($resultpage['assignTo']); ?></span> <?php } ?></a>

		<a onclick="alertspopupopen('action=assignafterconfirmationSales&queryId=<?php echo $_GET['id']; ?>&assignTo=<?php echo $resultpage['assignTo']; ?>','450px','auto');"><i class="fa fa-pencil dropbtn" aria-hidden="true" style="color:#82b767; cursor:pointer;"></i>Assign&nbsp;Query-Sales. <?php if ($resultpage['salesPersonId']!= 0) { ?> <span style="position: absolute; top: 6px; margin-left: 10px; background-color: #7a96ff; color: #fff; padding: 5px 10px; font-size: 11px; border-radius: 4px; text-align: center;"><?php  echo getSalesName($resultpage['salesPersonId']); ?></span> <?php } ?></a>

		<a onclick="alertspopupopen('action=assignafterconfirmationContarct"><i class="fa fa-pencil dropbtn" aria-hidden="true" style="color:#82b767; cursor:pointer;"></i>Assign&nbsp;Query-Contract.
		</a>



	</div>
	<script>
		function myFunction55555() {
			document.getElementById("myDropdown55555").classList.toggle("show");
			document.getElementById("PlusMinus6").classList.toggle("fa-minus-square");
		}
	</script>

<!-- Assign Query Ended  -->


	<!-- Client&nbsp;Information -->
	<a href="#" onClick="myFunction()" class="dropbtn"><i id="PlusMinus6" class="fa fa-plus-square dropbtn" aria-hidden="true" style="color:#82b767;"></i>Client&nbsp;Information</a>
	<div id="myDropdown" class="dropdown-content" style="min-width: 211px;border-left: 5px solid #82b767;">
	<?php if ($resultpage['quotationYes'] != 1 && $resultpage['quotationYes'] != 2) { ?>
	<a href="<?php echo $fullurl; ?>packageQueryhtml.php?id=<?php echo encode($resultpage['id']); ?>&downloadpackage=1&servicePrice=1" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>Download Itinerary</a><a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Itinerary: <?php echo $fullurl; ?>doc/<?php echo $resultpage['id']; ?>/3.html&source=&data=" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i>Share Itinerary</a><?php } ?>
	<?php
	$rsp = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId="' . decode($_GET['id']) . '" and status=1 ');
	$resultpageQuotation = mysqli_fetch_array($rsp);
	if ($resultpage['quotationYes'] == 2 && $resultpageQuotation['id'] != '' && $queryTypeId!=13) { ?>
		<a style="display:none;" href="#" onClick="alertspopupopen('action=createliveitinerary&quotationId=<?php echo encode($resultpageQuotation['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Update Itinerary</a>
		<a style="display:none;" href="showpage.crm?module=voucher&add=yes&id=<?php echo encode($resultvou['id']); ?>"><i class="fa fa-plus-square" aria-hidden="true" style="color:#82b767;"></i> Edit Voucher</a>
		<a style="display:none;" href="<?php echo $fullurl; ?>tcpdf/examples/getpdf.php?pageurl=<?php echo $fullurl; ?>download_quotations_itinerary.php?qid=<?php echo $resultpageQuotation['id']; ?>&queryId=<?php echo decode($_GET['id']); ?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>Download Itinerary</a>
		<!--<a href="showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['id']; ?>&quotationitinerary=1&newqid=<?php echo $resultpageQuotation['id']; ?>"><i class="fa fa-envelope" aria-hidden="true"></i>Email Itinerary</a>-->

		<?php
		$resultq = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId="' . decode($_GET['id']) . '" and isTourEx=0 and status=1');
		while ($resultDataq = mysqli_fetch_array($resultq)) { ?>
		<a  href="showpage.crm?module=ClientVoucher&qid=<?php echo encode($resultDataq['id']); ?>&voucherType=client" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i><?php echo ""; echo ' Client Voucher'; ?></a>
		
		<!-- <a  href="showpage.crm?module=ClientVoucher&qid=<?php echo encode($resultDataq['id']); ?>&&voucherType=preprint" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i>Pre-Print Voucher</a> -->

		<?php }
		$qnc = '0';
		$resultq = GetPageRecord('*', _QUOTATION_MASTER_, 'queryId="' . decode($_GET['id']) . '" and isTourEx=1');
		while ($resultDataq = mysqli_fetch_array($resultq)) { ?>
			<a  href="showpage.crm?module=ClientVoucher&qid=<?php echo encode($resultDataq['id']); ?>&queryId=<?php echo $_GET['id']; ?>" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i>
				<?php if ($resultDataq['isTourEx'] == 1) {
					$charc = range('A', 'Z');
					$makeQueryId = makeExtensionId($resultpage['displayId']) . "-" . $charc[$qnc];
					echo $makeQueryId;
				} ?>
			</a>
			<?php 
			$qnc++;
		} 
	} ?>
	<a href="showpage.crm?module=contacts&guestList=3&queryId=<?php echo $_REQUEST['id']; ?>&destinationId=<?php echo $resultpage['destinationId']; ?>" > <i class="fa fa-user" aria-hidden="true"></i>Guest List <?php
		// $select1 = '*';
		// $where1 = 'queryId=' . decode($_REQUEST['id']) . '';
		// $rs1 = GetPageRecord('id', 'guestList', $where1);
		// echo $totalguest = mysqli_num_rows($rs1);
	?></a>
	<?php if ($_REQUEST['quotations'] != 1) {
		if ($resultpage['clientType'] == 2) {
			$getphone =  getPrimaryPhone($resultpage['companyId'], 'contacts');
		}
		if ($resultpage['clientType'] == 1) {
			$getphone = getPrimaryPhone($resultpage['companyId'], "corporate");
		}
	?>
	<?php } ?>

	<!-- <a href="#" onClick="alertspopupopen('action=createwelcomelettervoucher&queryId=<?php echo decode($_GET['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Agent&nbsp;Welcome&nbsp;Letter</a> -->
	<?php
		$rs1 = GetPageRecord('*', 'letterMaster', '1 and status=1 order by id asc');
		while ($editresult11 = mysqli_fetch_array($rs1)) {
		?>
		<a href="#" onclick="alertspopupopen('action=letterTypeMaster&queryId=<?php echo decode($_GET['id']); ?>&letterType=<?php echo $editresult11['letterType']; ?>','900px','auto');"><i class="fa fa-comments" aria-hidden="true"></i><?php echo $editresult11['letterName']; ?></a>
	<?php } ?>

	<!-- <a href="#" onClick="alertspopupopen('action=welcomelettervoucher&queryId=<?php echo decode($_GET['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Welcome&nbsp;Letter</a>

	<a href="#" onClick="alertspopupopen('action=documentacknowledgement&queryId=<?php echo decode($_GET['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Document&nbsp;Acknowledgement</a>
	<a href="#" onClick="alertspopupopen('action=generatecontactList&queryId=<?php echo decode($_GET['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Contact&nbsp;List</a>
	<a href="#" onClick="alertspopupopen('action=generatefeedbackform&queryId=<?php echo decode($_GET['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Feedback&nbsp;Form</a>
	<a href="#" onClick="alertspopupopen('action=generateAgentfeedback&queryId=<?php echo decode($_GET['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Agent&nbsp;Feedback</a>
	<a href="#" onClick="alertspopupopen('action=generateBrifeingSheet&queryId=<?php echo decode($_GET['id']); ?>','900px','auto');"><i class="fa fa-pencil" aria-hidden="true"></i>Brifeing Sheet</a> -->
	</div>
	<style>
		.dropdown {
			position: relative;
			display: inline-block;
		}
		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			overflow: auto;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
		}
		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}
		.dropdown a:hover {
			background-color: #ddd;
		}
		.show {
			display: block;
		}
	</style>
	<script>
		/* When the user clicks on the button,
	toggle between hiding and showing the dropdown content */
		function myFunction() {
			document.getElementById("myDropdown").classList.toggle("show");
			document.getElementById("PlusMinus6").classList.toggle("fa-minus-square");
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
	<?php if ($resultpage['quotationYes'] == 2 && $resultpageQuotation['id'] != '') { ?>
	<!--<a href="#" onclick="alertspopupopen('action=travelArrangement&queryId=<?php //echo $_REQUEST['id'];
	?>&quotationId=<?php //echo $resultpageQuotation['id'];
	?>','1200px','auto');"><i class="fa fa-file-text" aria-hidden="true"></i> Travel&nbsp;Arrangement&nbsp;List</a>-->
	<?php } ?>
	<?php if ($_REQUEST['quotations'] != 1) {
		if ($resultpage['clientType'] == 2) {
			$getphone =  getPrimaryPhone($resultpage['companyId'], 'contacts');
		}
		if ($resultpage['clientType'] == 1) {
			$getphone = getPrimaryPhone($resultpage['companyId'], "corporate");
		}
	?>
	<?php } ?>
	<?php
	if ($resultpageQuotation['status'] == 1) { ?>
	<?php } ?>
	</div>
	<!--<div style="margin-top: 55px;">
	<?php
	$select = '';
	$where = '';
	$rs = '';
	$select = 'queryStatus,adddate';
	$where = 'queryid=' . decode($_GET['id']) . ' order by adddate desc';
	$rs = GetPageRecord($select, _QUERYMAILS_MASTER_, $where);
	while ($querylisting = mysqli_fetch_array($rs)) {
	?>
	<div class="queryrightbox" style="border-left:4px solid #<?php if ($querylisting['queryStatus'] == 1) {
																	echo '2ca1cc';
																}
																if ($querylisting['queryStatus'] == 2) {
																	echo 'FF6600';
																}
																if ($querylisting['queryStatus'] == 3) {
																	echo 'wonquery';
																}
																if ($querylisting['queryStatus'] == 4) {
																	echo 'lossquery';
																}
																if ($querylisting['queryStatus'] == 5) {
																	echo '2ca1cc';
																}
																if ($querylisting['queryStatus'] == 0) {
																	echo '2ca1cc';
	} ?>;">
	<div class="heading"><?php if ($querylisting['queryStatus'] == 1) {
									echo 'Assigned';
								}
								if ($querylisting['queryStatus'] == 2) {
									echo 'Reverted';
								}
								if ($querylisting['queryStatus'] == 3) {
									echo 'Won';
								}
								if ($querylisting['queryStatus'] == 4) {
									echo 'Lose';
								}
								if ($querylisting['queryStatus'] == 5) {
									echo 'Close';
								}
								if ($querylisting['queryStatus'] == 0) {
									echo 'Assigned';
	} ?></div>
	<div class="datetime"><?php $originalDate = $querylisting['adddate'];
	echo date("g:iA - d-m-Y", strtotime($originalDate)); ?></div>
	</div>
	<?php } ?>
	</div>-->
	<?php if ($resultpage['queryStatus'] == '3') { ?>
	<style>
		.clientandsupplierpaymentouter {
			border: 1px solid #2374ab;
			padding: 0px;
			text-align: center;
		}
		.clientandsupplierpaymentouter .amount {
			font-size: 18px;
			font-weight: 600;
			padding: 2px;
			text-align: center;
			color: #2374ab;
		}
		.clientandsupplierpaymentouter .lbl {
			background-color: #2374ab;
			color: #FFFFFF;
			font-size: 11px;
			padding: 5px;
			text-align: center;
			text-transform: uppercase;
		}
	</style>
	<div style=" border:1px #a7bed5 solid; padding:0px; border-bottom:0px #a7bed5 solid;background-color: #fcfcfc">
	<table width="100%">
		<tr><td colspan="3" style="font-weight: 500;font-size: 13px;color:#626262;">Client Payment Information&nbsp;(Amt. in <?php echo getCurrencyName($baseCurrencyId); ?>)</td></tr>
	<tr>
		<td width="33%" align="left" valign="top">
			<div class="clientandsupplierpaymentouter" style="border:1px solid #23ab69;">
				<div class="amount" style="color:#23ab69;">
				
				<?php if($totalClientCost==''){ echo '0'; }else{ echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$totalClientCost); } ?></div>

				<div class="lbl" style="background-color:#23ab69;">Client Cost</div>
			</div>
		</td>
		
																		
		<td width="33%" valign="top">
			<div class="clientandsupplierpaymentouter" style="border:1px solid #2374ab;">
				<div class="costtabsbox">
					<div class="amount" style="color:#2374ab;">
					<?php if ($paidAmount==''){ echo '0'; }else{ echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$paidAmount); } ?></div>
					<div class="lbl" style="background-color:#2374ab;">Received</div>
				</div>
			</div>
		</td>
		<td width="33%" valign="top">
			<div class="clientandsupplierpaymentouter" style="border:1px solid #f17f00;">
				<div class="costtabsbox">
					<div class="amount" style="color:#f17f00;">
					<?php if ($clientPedingAMT=='') { echo '0'; }else{ echo getChangeCurrencyValue_New($baseCurrencyId,$quotationId,$clientPedingAMT); } ?></div>
					<div class="lbl" style="background-color:#f17f00;">Pending</div>
				</div>
			</div>
		</td>
	</tr>
	</table>
	<!-- <table width="100%">
	<tr>
		<td width="33%" valign="top">
			<div class="clientandsupplierpaymentouter">
				<div class="costtabsbox">
					<div class="amount"><?php 
					// if ($resultpage['totalQueryCostwithoutpercent'] == '') {
					// 							echo '0';
					// 						} else {
					// 							echo $resultpage['totalQueryCostwithoutpercent'];
					// } 
					?></div>
					<div class="lbl">Supplier&nbsp;AMOUNT</div>
				</div>
			</div>
		</td>
		<td width="33%" valign="top">
			<div class="clientandsupplierpaymentouter">
				<div class="costtabsbox">
					<div class="amount"><?php
					//  if ($totalpaid != "") {
					// 							echo $totalpaid;
					// 						} else {
					// 							echo "0";
					// } 
					?></div>
					<div class="lbl">RECEIVED</div>
				</div>
			</div>
		</td>
		<td width="33%" align="left" valign="top">
			<div class="clientandsupplierpaymentouter" style="border:1px solid #f17f00;">
				<div class="costtabsbox">
					<div class="amount" style="color:#f17f00;"><?php 
					// $totalrest = $resultpage['totalQueryCostwithoutpercent'] - $totalpaid;
					// 												if ($totalrest < 1 && $requesetdata['finalCost'] != '' && $requesetdata['finalCost'] != '0') {
					// $gdf = 1; ?> Paid <?php //} else { ?><?php //echo $totalrest; ?><?php //}
					 ?></div>
					<div class="lbl" style="background-color:#f17f00;"><?php
					//  if ($gdf == 1) {
					// 															echo '&nbsp;';
					// 														} else {
					// 															echo 'PENDING';
					// } 
					?></div>
				</div>
			</div>
		</td>
	</tr>
	</table>
	</div> -->
	<?php } ?>
	<?php if ($resultpage['moduleType'] == 1) { ?>
	<div style=" border:1px #4CAF50 solid; padding:7px; border-bottom:2px #4CAF50 solid;">
	<div style="margin-bottom:2px; font-size:14px; font-weight:500 !important; margin-top:15px;">Current Status: <?php if ($resultpage['queryStatus'] != '') { ?><span style="    font-weight: 500;
	font-size: 12px;
	background-color: #FFFFCC;
	padding: 5px 10px;
	border: 1px solid #ffaf37;
	margin-bottom: 5px; "><?php if ($resultpage['queryStatus'] == 7) { echo 'Follow-Up';
	} ?><?php if ($resultpage['queryStatus'] == 2) {
	echo 'Reverted';
	} ?><?php if ($resultpage['queryStatus'] == 1) {
	echo 'Assigned';
	} ?><?php if ($resultpage['queryStatus'] == 3) {
	echo 'Confirmed';
	} ?><?php if ($resultpage['queryStatus'] == 6) {
	echo 'Quote Sent';
	} ?><?php if ($resultpage['queryStatus'] == 5) {
	echo 'Quotation&nbsp;Generated';
	} ?><?php if ($resultpage['queryStatus'] == 4) {
	echo 'Lost';
	} ?><?php if ($resultpage['queryStatus'] == 10) {
	echo 'Created';
	} ?><?php if ($resultpage['queryStatus'] == 20) {
	echo 'Cancelled';
	} ?><?php if ($resultpage['queryStatus'] == 11) {
		echo 'TMS';
	} ?></span> <?php } ?> </div>
	<style>
		.currentstatuschangeicon {
			border-radius: 5px;
			color: #fff;
			background-color: #82b767;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.confirmstatuschangeicon {
			border-radius: 5px;
			color: #fff;
			background-color: #82b767;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.sentstatuschangeicon {
			border-radius: 5px;
			color: #fff;
			background-color: #2ca1cc;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.timelimitstatuschangeicon {
			border-radius: 5px;
			color: #fff;
			background-color: #333333;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.loststatuschangeicon {
			border-radius: 5px;
			color: #fff;
			background-color: #c75858;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.notreachable {
			border-radius: 5px;
			color: #fff;
			background-color: #ef1212;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.bookwithme {
			border-radius: 5px;
			color: #fff;
			background-color: #28b8db;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.talkprogress {
			border-radius: 5px;
			color: #fff;
			background-color: #11b76c;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.finalyze {
			border-radius: 5px;
			color: #fff;
			background-color: #029700;
			padding: 1px;
			width: 100%;
			height: 30px;
		}
		.paddingclass {
			padding: 8px 4px !important;
			border: 2px #efefef solid !important;
			cursor: pointer;
			box-sizing: border-box;
			height: auto !important;
			font-size: 11px;
			min-width: 63px;
			margin: 2px;
			border-radius: 0px;
			width: auto;
		}
		.paddingclassactive {
			border: 2px #000000 solid !important;
			cursor: default !important;
		}
	</style>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px;">
	<tr>
		
		<td align="center" valign="top">
			<div class="timelimitstatuschangeicon paddingclass <?php if ($resultpage['queryStatus'] == 5) { ?>paddingclassactive<?php } ?>" title="Quotation&nbsp;Generated" style="<?php if($resultpage['queryStatus']== 3) { ?>cursor:no-drop;<?php }else{?>cursor:pointer;<?php } ?>background-color:#a598d9 !important;">Quotation<br />Generated</div>
		</td>
		<td align="center" valign="top">
			<div class="sentstatuschangeicon paddingclass  <?php if ($resultpage['queryStatus'] == 6) { ?>paddingclassactive<?php } ?>" title="Quote Sent"  <?php if ($resultpage['queryStatus']!= 3) { ?> onclick="alertspopupopen('action=queryStatus&queryId=<?php echo $resultpage['id']; ?>&status=6','450px','auto');" <?php } else { ?> style="cursor:no-drop;" <?php } ?>>Quote<br />Sent</div>
		</td>
		<td align="center" valign="top">
			<div class="sentstatuschangeicon paddingclass <?php if ($resultpage['queryStatus'] == 7) { ?>paddingclassactive<?php } ?>" <?php if ($resultpage['queryStatus']!= 3) { ?> onClick="alertspopupopen('action=queryStatus&queryId=<?php echo $resultpage['id']; ?>&status=7','450px','auto');" <?php } else { ?> style="cursor:no-drop;" <?php } ?> title="Quotation Followup" style="cursor:pointer;">Quotation<br />Followup</div>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="font-size:13px;">
			<div class="confirmstatuschangeicon paddingclass <?php if ($resultpage['queryStatus'] == 3) { ?>paddingclassactive<?php } ?>" title="Query Confirmed" >Quotation<br />Confirmed</div>
		</td>
		<td align="center" valign="top" style="font-size:13px;">
			<div class="notreachable paddingclass <?php if ($resultpage['queryStatus'] == 20) { ?>paddingclassactive<?php } ?>" onClick="alertspopupopen('action=cancelvoucher&queryId=<?php echo encode($resultpage['id']); ?>','600px','auto');" style="cursor:pointer;">Query<br />Cancel</div>
		</td>
		<td align="center" valign="top">
			<div class="loststatuschangeicon paddingclass  <?php if ($resultpage['queryStatus'] == 4) { ?>paddingclassactive<?php } ?>" title="Query Lost" <?php if($resultpage['queryStatus']!=3){ ?> onclick="alertspopupopen('action=queryStatus&queryId=<?php echo $resultpage['id']; ?>&status=4','450px','auto');" <?php  } else { ?> style="cursor:no-drop;" <?php } ?> >Query<br />Lost</div>
		</td>
	</tr>


	<?php 

	$rs1t=GetPageRecord('*','companySettingsMaster','id=1');
	$editresultr1=mysqli_fetch_array($rs1t);
	$TMS=clean($editresultr1['TMS']);
	if($TMS!=2){?>

	<tr>
		<!-- Status For TMS Linking started  -->
		<td align="center" valign="top">
		<div class="sentstatuschangeicon paddingclass  <?php if ($resultpage['queryStatus'] == 4) { ?>paddingclassactive<?php } ?>" title="Booking On TMS" <?php if ($resultpage['queryStatus'] != 3) { ?> onclick="alertspopupopen('action=bookingTMS&queryId=<?php echo $resultpage['id']; ?>&status=11','650px','auto');" <?php  } ?> style="cursor:pointer;">Booking On<br />TMS</div>
		</td>
		<!-- Status For TMS Linking Ended  -->
	</tr>
	<?php } ?>

	<tr>
		<td colspan="4" style="font-weight: 500;font-size: 14px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" style="font-weight: 500; font-size: 14px; font-weight:500 !important;">Query Notes & Reminder</td>
	</tr>
	<tr>
		<td align="center" valign="top">
			<div class="bookwithme paddingclass" <?php if ($resultpage['queryStatus']!= 3) { ?> onClick="alertspopupopen('action=addnotesinquery&queryId=<?php echo $resultpage['id']; ?>&type=2','600px','auto');" style="cursor:pointer;" <?php } else { ?> style="cursor:no-drop;" <?php } ?>>Internal<br />Note's</div>
		</td>
		<td align="center" valign="top" style="font-size:13px;">
			<div class="notreachable paddingclass" <?php if ($resultpage['queryStatus']!= 3) { ?> onClick="alertspopupopen('action=addnotesinquery&queryId=<?php echo $resultpage['id']; ?>&type=1&assignTo=<?php echo $resultpage['assignTo'] ?>','600px','auto');" style="cursor:pointer;" <?php } else { ?> style="cursor:no-drop;" <?php } ?>>Not<br />reachable</div>
		</td>
		<td align="center" valign="top">
			<div class="talkprogress paddingclass" <?php if ($resultpage['queryStatus']!= 3) { ?> onClick="alertspopupopen('action=addnotesinquery&queryId=<?php echo $resultpage['id']; ?>&type=3','600px','auto');" style="cursor:pointer;" <?php } else { ?> style="cursor:no-drop;" <?php } ?>>Talk&nbsp;in<br />progress</div>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top">
			<div class="finalyze paddingclass" <?php if ($resultpage['queryStatus']!= 3) { ?> onClick="alertspopupopen('action=addnotesinquery&queryId=<?php echo $resultpage['id']; ?>&type=4','600px','auto');" style="cursor:pointer;" <?php } else { ?> style="cursor:no-drop;" <?php } ?>>Finalizing<br />soon</div>
		</td>
	</tr>
	</table>
	</div>
	<?php } ?>
	<div id="autowebitinerary"></div>
	<?php if ($resultpage['moduleType'] == 2 || $resultpage['queryStatus'] == 2 || $resultpage['queryStatus'] == 1 || $resultpage['queryStatus'] == 10) {
	} else { ?> <div style="    overflow: auto;
	max-height: 400px;
	padding: 4px;
	background-color: #f3f3f3;
	padding: 10px;
	border-bottom: 2px solid #cccccc5e;">
	<?php if($resultpage['queryStatus'] == 2 || $resultpage['queryStatus'] == 1 || $resultpage['queryStatus'] == 10){ }else{ ?>
	Remarks

	<br>
<div>
	<?php
		if($resultpage['queryStatus'] == 11){

			$gt = "";
			$gt = GetPageRecord('*','tmsBooking','queryId="'.$resultpage['id'].'" and queryStatus=11'); 
			$tmsData = mysqli_fetch_array($gt);

		?>
		
		<div>
			<br>
			<h4>Booked On TMS  ID: <?php echo $tmsData['BookingId']; ?></h4>
			

			<?php 
			if($tmsData['domesticE']==1){
				echo ''.'Domestic-EBK'.'<br>';
			}
			if($tmsData['domesticS']==1){
				echo ''.'Domestic-SPL'.'<br>';
			}
			if($tmsData['internationF']==1){
				echo ''.'Internation-Fixed Tour'.'<br>';
			}
			if($tmsData['internationC']==1){
				echo ''.'Internation Customized'.'<br>';
			}
			if($tmsData['carB']==1){
				echo ''.'Car Booking'.'<br>';
			}
			if($tmsData['hacH']==1){
				echo ''.'HAC-Hotel'.'<br>';
			}
			if($tmsData['domesticH']==1){
				echo ''.'Domestic Hotels'.'<br>';
			}
			if($tmsData['flightT']==1){
				echo ''.'Flight Ticket'.'<br>';
			}
			if($tmsData['trainT']==1){
				echo ''.'Train Ticket'.'<br>';
			}
			if($tmsData['grp']==1){
				echo ''.'GRP'.'<br>';
			}
			if($tmsData['pab']==1){
				echo ''.'PAB'.'<br>';
			}
			?>

			<span>
				<br>
				<!-- <?php echo $tmsData['tmsDetails']; ?> -->
			</span>
		</div>

		<?php } ?>
</div>



	<?php } ?>
	</div><?php } ?>
	<div style="overflow:auto; max-height:400px;" id="loadnotesinner">
	Loading... </div>
	<script>
		function loadinnernotes(){
	$('#loadnotesinner').load('load_innerquerynotes.php?id=<?php echo $resultpage['id']; ?>');
	}
	loadinnernotes();
	</script>
	</td>
	<?php } ?>
	</tr>
	</table>
	<div style="display:none;" id="changequerystatusdiv"></div>
	<script>
		function changequerystatus(id) {
			$('#changequerystatusdiv').load('frmaction.php?action=changequerymailstatus&id=' + id);
		}
		function showcontenttab(id) {
			$('.displaytab').hide();
			$('.querymaillisting').show();
			$('#maintab' + id).hide();
			$('#displaymaintab' + id).show();
		}
		function hidecontenttab(id) {
			$('#maintab' + id).show();
			$('#displaymaintab' + id).hide();
		}
		$('#replymainbox').hide();
		comtabopenclose('linkbox', 'op2');

	<?php 
	if ( $replymainbox == 1 || $_GET['itinerary'] == 1 || $_GET['reminvoice'] == 1 || $_GET['supminvoice'] == 1) { ?>
		$('#replymainbox').show();
		$('#replybtn').hide();
		<?php 
	} ?>
	</script>
	<?php 
} ?>
<style>
	.querywonlostclose {
		position: relative;
	} 
	.gridtable .header {
		padding-bottom: 10px !important;
		padding-left: 0px !important;
	}
</style>