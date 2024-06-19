<?php
if ($addpermission != 1 && $_GET['id'] == '') {
	header('location:' . $fullurl . '');
}
if ($editpermission != 1 && $_GET['id'] != '') {
	header('location:' . $fullurl . '');
}
if ($_GET['id'] == '') {
	$where = ' firstName="" and  addedBy="' . $_SESSION['userid'] . '"';
	deleteRecord(_CONTACT_MASTER_, $where);
	$dateAdded= date('Y-m-d');
	$namevalue = 'firstName="",addedBy="' . $_SESSION['userid'] . '",dateAdded="' . $dateAdded . '"';
	$lastId = addlistinggetlastid(_CONTACT_MASTER_, $namevalue);
}
if ($_GET['id'] != '') {
	$id = clean(decode($_GET['id']));
	$select1 = '*';
	$where1 = 'id="' . $id . '"';
	$rs1 = GetPageRecord($select1, _CONTACT_MASTER_, $where1);
	$editresult = mysqli_fetch_array($rs1);
	$nationalityId = $editresult['nationality'];
	$tourType = $editresult['tourType'];
	$mealPreference = $editresult['mealPreference'];
	$physicalCondition = $editresult['physicalCondition'];
	$seatPreference = $editresult['seatPreference'];
	$editassignTo = clean($editresult['assignTo']);
	$editcontacttitleId = clean($editresult['contacttitleId']);
	$editfirstName = clean($editresult['firstName']);
	$editAge = clean($editresult['guestAge']);
	$editlastName = clean($editresult['lastName']);
	$editdesignationId = clean($editresult['designationId']);

	$contactType = clean($editresult['contactType']);
	$corporateId = clean($editresult['corporateId']);
	$gradeId = clean($editresult['gradeId']);
	$designationName = clean($editresult['designationName']);

	$editbirthDate = clean($editresult['birthDate']);
	$editanniversaryDate = clean($editresult['anniversaryDate']);
	$editcompanyTypeId = clean($editresult['companyTypeId']);
	$editcountryId = clean($editresult['countryId']);
	$editmarketType = clean($editresult['marketType']);
	$editstateId = clean($editresult['stateId']);
	$editcityId = clean($editresult['cityId']);
	$edittitle = clean($editresult['title']);
	$addedBy = clean($editresult['addedBy']);
	$dateAdded = clean($editresult['dateAdded']);
	$modifyBy = clean($editresult['modifyBy']);
	$modifyDate = clean($editresult['modifyDate']);
	$editremark1 = clean($editresult['remark1']);
	$editremark2 = clean($editresult['remark2']);
	$editremark3 = clean($editresult['remark3']);
	$editpinCode = clean($editresult['pinCode']);
	$mobilePin = clean($editresult['mobilePin']);
	$editfacebook = clean($editresult['facebook']);
	$edittwitter = clean($editresult['twitter']);
	$editlinkedIn = clean($editresult['linkedIn']);
	$preAccomodationMaster = clean($editresult['preAccomodationMaster']);
	$lastId = $editresult['id'];
	$editqueryId = clean($editresult['queryId']);
	$edittourId = clean($editresult['tourId']);
	$editreferenceNo = clean($editresult['referenceNo']);
	$editagentName = clean($editresult['agentName']);
	$editqueryId2 = clean($editresult['queryId2']);
}


$_REQUEST['guestList'];

$queryRecord = GetPageRecord('*','queryMaster','id="'.decode($_REQUEST['queryId']).'"');
$queryData = mysqli_fetch_assoc($queryRecord);
$querytourId = makeQueryTourId($queryData['id']);
$referanceNumber = $queryData['referanceNumber'];
$displayId = makeQueryId($queryData['id']);
$agentName = showClientTypeUserName($queryData['clientType'],$queryData['companyId']);


?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<?php if($_REQUEST['guestList']==3 && $_REQUEST['queryId']!=''){ ?> 

					<div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><?php if ($_GET['id'] != '' && $_REQUEST['guestList']==3 ) { ?>Update<?php } else { ?>Add<?php } ?> <?php echo 'GUEST'; ?> </span></div> 
				<?php }else{ ?>
				
				<div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><?php if ($_GET['id'] != '') { ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span></div>

				<?php } ?>
			</td>
			<td align="right">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td></td>
						<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
						<td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn" onclick="formValidation('addeditfrm','submitbtn','1');" /></td>
						<td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if ($_GET['id'] != '') { ?>onclick="view('<?php echo $_GET['id']; ?>');" <?php } else { ?>onclick="cancel();" <?php } ?> /></td>
					</tr> 
				</table>
			</td>
		</tr>

	</table>
</div>
<div id="pagelisterouter" style="padding-left:0px;">
	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">

		<div class="addeditpagebox" style="padding-bottom: 100px !important;">
			<input name="action" type="hidden" id="action" value="editcontacts" />
			<input name="savenew" type="hidden" id="savenew" value="0" />
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr width="60%" >
					<td colspan="12" align="left" valign="top">
						<div class="innerbox">
							<h2>Contact Information<?php
							if (trim($_REQUEST['fc']) != '') {
								$nod = 1;
								$select = '*';
								$where = '  familyCode="' . $_REQUEST['fc'] . '" and familyRelation="Family Head" order by id desc';
								$rs = GetPageRecord($select, _CONTACT_MASTER_, $where);
								while ($familyrelation = mysqli_fetch_array($rs)) {
									$editassignTo = $familyrelation['assignTo'];
									$editcountryId = $familyrelation['countryId'];
									$editaddress1 = $familyrelation['address1'];
									$editaddress2 = $familyrelation['address2'];
									$editaddress3 = $familyrelation['address3'];
									$editpinCode = $familyrelation['pinCode'];
									$mealPreference = $familyrelation['mealPreference'];
									$physicalCondition = $familyrelation['physicalCondition'];
									$seatPreference = $familyrelation['seatPreference'];
									$phonenNew = getPrimaryPhone($familyrelation['id'], 'contacts');
									$emailNew = getPrimaryEmail($familyrelation['id'], 'contacts');
									$familyhead = '1';
								}
							}
							?></h2>
						</div>
					</td>
					
				</tr>
				
				<tr>
					<td width="50%" align="left" valign="top" style="padding-right:20px;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="16%">
									<div class="griddiv" style="max-width: 225px;"><label>
										
											<div class="gridlable">Contact&nbsp;Type</div>
											<select id="contactType" name="contactType" class="gridfield" displayname="Contact Type" autocomplete="off" onchange="selectContactType(this.value);">
												<option value="2" <?php if (2 == $contactType || $_REQUEST['BToCIdedit']==2 ) { ?> selected="selected" <?php } ?> >B2C</option>
												<option value="1" <?php if (1 == $contactType) { ?>selected="selected" <?php } ?>>Employee</option>
												<option value="3" <?php if (3 == $contactType || $_REQUEST['guestList']==3 ) { ?>selected="selected" <?php } ?>>Guest List</option>
											</select>
										</label>
									</div>
								</td>
								<td width="17%" id="corporateIdDiv">
									<div class="griddiv"><label>
											<div class="gridlable">Corporate Name</div>
											<select id="corporateId" name="corporateId" class="gridfield" displayname="Corporate Name" autocomplete="off">
												<option value="">Select</option>
												<?php
												$rs = GetPageRecord('*', 'corporateMaster', ' 1 and bussinessType in ( select id from businessTypeMaster where name="Corporate" ) and deletestatus=0 order by name asc');
												while ($corporateData = mysqli_fetch_array($rs)) {
												?>
													<option value="<?php echo strip($corporateData['id']); ?>" <?php if ($corporateData['id'] == $corporateId) { ?>selected="selected" <?php } ?>><?php echo strip($corporateData['name']); ?></option>
												<?php } ?>
											</select>
										</label>
									</div>
								</td>
								<td width="17%" id="gradeIdDiv" style="padding-left: 8px;">
									<div class="griddiv"><label>
											<div class="gridlable">Grade Name</div>
											<select id="gradeId" name="gradeId" class="gridfield" displayname="Grade Name" autocomplete="off">
												<option value="">Select</option>
												<?php
												$rs = GetPageRecord('*', 'gradeMaster', ' 1 and deletestatus=0 order by name asc');
												while ($gradeData = mysqli_fetch_array($rs)) {
												?>
													<option value="<?php echo strip($gradeData['id']); ?>" <?php if ($gradeData['id'] == $gradeId) { ?>selected="selected" <?php } ?>><?php echo strip($gradeData['name']); ?></option>
												<?php } ?>
											</select>
										</label>
									</div>
								</td>
								<?php //if($_REQUEST['guestList']==3 || $contactType == 3){ ?>
								<td style="padding-left: 10px;" id="tourIdquery">
								<div class="griddiv"><label>
										<div class="gridlable">Tour Id</div>
										<input type="text" name="tourId" id="tourId" class="gridfield" value="<?php if($querytourId!=''){ echo $querytourId ; }else{ echo $editresult['tourId']; } ?> " diplayname="Tour Id">
									</label></div>
								</td>
								
								<td style="padding-left: 10px;" id="QueryIdquery">
								<div class="griddiv"><label>
										<div class="gridlable">Query Id</div>
										<input type="text" name="QueryId" id="QueryId" class="gridfield" value="<?php if($displayId!=''){ echo $displayId ; }else{ echo $editresult['queryId']; } ?> " diplayname="Tour Id">
									</label></div>
									<input type="hidden" name="QueryId2" id="QueryId2" value="<?php if($queryData['id']!=''){ echo $queryData['id']; }else{ echo $editresult['queryId2']; }  ?>">
								</td>
								<td style="padding-left: 10px;" id="QueryreferenceNo">
								<div class="griddiv"><label>
										<div class="gridlable">Reference No.</div>
										<input type="text" name="ReferenceNo" id="ReferenceNo" class="gridfield" value="<?php if($referanceNumber!=''){ echo $referanceNumber ; }else{ echo $editresult['referenceNo']; } ?> " diplayname="Reference Number">
									</label></div>
								</td>
								<td style="padding-left: 10px;" id="QueryAgentName">
								<div class="griddiv"><label>
										<div class="gridlable">Agent Name</div>
										<input type="text" name="AgentName" id="AgentName" class="gridfield" value=" <?php if($agentName!=''){ echo $agentName ; }else{ echo $editresult['agentName']; } ?> " diplayname="Agent Name">
									</label></div>
								</td>
								<?php //}else{ } ?>
							</tr>
						</table>
						<script type="text/javascript">
							function selectContactType(cType) {
								
								if (cType == 2) {
									$('#corporateIdDiv').hide();
									$('#familyCodeDiv').show();
									$('#gradeIdDiv').hide();
									$('#firstNameLable').text('B2C First Name');
									$('#lastNameLable').text('B2C Last Name');
									$('#assignToLable').text('Sales Person');
									$('#salesPersonId').show();
									$('#socilMediaId').show();
									$('#newsLetterId').show();
									$('#preferancesId').show();
									$('#QueryAgentName').hide();
									$('#QueryreferenceNo').hide();
									$('#tourIdquery').hide();
									$('#QueryIdquery').hide();
									
								} 
								if (cType == 3) {
									$('#socilMediaId').hide();
									$('#newsLetterId').hide();
									$('#preferancesId').hide();
									$('#familyCodeDiv').hide();
									$('#salesPersonId').hide();
									$('#corporateIdDiv').hide();
									$('#gradeIdDiv').hide();
									$('#QueryAgentName').show();
									$('#QueryreferenceNo').show();
									$('#tourIdquery').show();
									$('#QueryIdquery').show();
									$('#firstNameLable').text('Guest First Name');
									$('#lastNameLable').text('Guest Last Name');

									// $('#assignToLable').text('Reporting Person');
									
								} 
								if (cType == 1) {
								
									$('#familyCodeDiv').hide();
									$('#QueryAgentName').hide();
									$('#QueryreferenceNo').hide();
									$('#tourIdquery').hide();
									$('#QueryIdquery').hide();
									$('#corporateIdDiv').show();
									$('#gradeIdDiv').show();
									$('#empdesignationId').show();
									$('#maximizeDiv').show();
									$('#firstNameLable').text('Employee First Name');
									$('#lastNameLable').text('Employee Last Name');
									$('#assignToLable').text('Reporting Person');

								}
								
							}
							<?php
							if ($contactType > 0) { ?>
								selectContactType(<?php echo $contactType; ?>);
							<?php } else { ?>
								selectContactType(2);
							<?php } ?>
							function geuslistSelected(){ 
							var contactTypevalue = $("#contactType").val();
								// document.write(contactTypevalue);
							if(contactTypevalue == 3){
							
								$('#socilMediaId').hide();
								$('#newsLetterId').hide();
								$('#preferancesId').hide();
								$('#familyCodeDiv').hide();
								$('#salesPersonId').hide();
								$('#corporateIdDiv').hide();
								$('#gradeIdDiv').hide();
								$('#QueryAgentName').show();
								$('#QueryreferenceNo').show();
								$('#tourIdquery').show();
								$('#QueryIdquery').show();
							}
						}
						geuslistSelected();
						</script>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<h2 class="childinformation">Personal Information</h2>
							</tr>
							<tr>
								<td width="16%" style="padding-right:10px;">

									<div class="griddiv">
										<label>
											<?php
											$nationalityId2=0;
											$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
											$editresultcmp=mysqli_fetch_array($rs1cmp);
											$nationalitycmp=clean($editresultcmp['id']);
											$nationalityId2=clean($editresultcmp['nationality']);
											$compcountryCode=clean($editresultcmp['compcountryCode']); 
											?>
											<div class="gridlable">Nationality<span class="redmind"></span></div>
											<select id="nationality" name="nationality" class="gridfield validate" displayname="Nationality" autocomplete="off">
												<option value="">Select</option>
												<?php
												$select = '';
												$where = '';
												$rs = '';
												$select = '*';
												$where = ' deletestatus=0 and type=0 order by name asc';
												$rs = GetPageRecord($select, 'nationalityMaster', $where);
												while ($resListing = mysqli_fetch_array($rs)) {
												?>
												<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id'] == $nationalityId){ ?>selected="selected"<?php }elseif($resListing['id'] == $nationalityId2){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
												<?php } ?>
											</select>
										</label>
									</div>
								</td>
								<td width="17%" style="padding-right:10px;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Title<span class="redmind"></span></div>
											<select id="contacttitleId" name="contacttitleId" class="gridfield validate" displayname="Title" autocomplete="off">
												<option value="">None</option>
												<?php
												$select = '';
												$where = '';
												$rs = '';
												$select = '*';
												$where = ' deletestatus=0 and status=1 order by id asc';
												$rs = GetPageRecord($select, _NAME_TITLE_MASTER_, $where);
												while ($resListing = mysqli_fetch_array($rs)) {
												?>
													<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editcontacttitleId) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
												<?php } ?>
											</select>
										</label>
									</div>
								</td>
								<td width="22%" style="padding-right:10px;position:relative;">
									<div class="griddiv"><label>
											<div class="gridlable" id="firstNameLable">First Name<span class="redmind"></span> </div>
											<input name="firstName" oninput="search();" type="text" class="gridfield validate" id="firstName" value="<?php echo $editfirstName; ?>" displayname="First Name" maxlength="100" />
										</label>
									</div>

									<div id="getbcguestName" style="display:none;position: absolute; background-color: #f5f5f5; border: 1px solid #ccc; z-index: 99; top: 55px; left: 0px; width: 250px; overflow: auto; max-height: 240px; box-shadow: 2px 2px 7px #0000003d;"></div>
									
								</td>
								

								<td width="22%" style="padding-right:10px;">
									<div class="griddiv"><label>
											<div class="gridlable" id="middleNameLable">Middle Name</div>
											<input name="middleName" type="text" class="gridfield" id="middleName" value="<?php echo $editresult['middleName']; ?>" displayname="Middle Name" maxlength="100" />
										</label>
									</div>
								</td>

								<td width="22%">
									<div class="griddiv"><label>
											<div class="gridlable" id="lastNameLable">Last Name<span class=""></span> </div>
											<input name="lastName" type="text" class="gridfield " id="lastName" value="<?php echo $editlastName; ?>" displayname="Last Name" maxlength="100" />
										</label>
									</div>
								</td>
							</tr>
							
						<script>
							function search(e){
									var fullName = $("#firstName").val();
									var contactType = $("#contactType").val();

									$('#getbcguestName').load(`searchaction.php?action=searchGuestEmp&fullName=${encodeURI(fullName)}&contactType=${contactType}`);
									$('#getbcguestName').show();
									
							}
						</script>

							<tr>
								<td width="16%" style="padding-right:10px;">
									<div class="griddiv"><label>
											<div class="gridlable" id="lastNameLable">Gender<span class="redmind"></span> </div>
											<select name="gender" id="gender" class="gridfield validate" displayname="Gender">
												<option value="">Select</option>
												<option value="Male" <?php if ($editresult['gender'] == 'Male') { ?> selected="selected" <?php } ?>>Male</option>
												<option value="Female" <?php if ($editresult['gender'] == 'Female') { ?> selected="selected" <?php } ?>>Female</option>
											</select>
										</label>
									</div>
								</td>

								<td width="20%" style="padding-right:10px;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Date of Birth<span class=""></span></div>
											<input name="birthDate" type="text" id="birthDate" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($editbirthDate != '' && $editbirthDate != '1970-01-01') { echo date("d-m-Y", strtotime($editbirthDate));} ?>" />
										</label>
									</div>
								</td>

								<!-- Started age and lead pax person check -->
								<td width="20%" style="padding-right:10px;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Age</div>
											<input name="guestAge" type="text" id="guestAge" class="gridfield" autocomplete="off" 
											value="<?php  echo $editAge; ?> "  />
										</label>
									</div>
								</td>
								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="border-bottom: none;">
										<label>
											<div class="gridlable" >Lead Pax</div>
											<div style="padding:3px 6px; font-size:12px; color:#009900;">
												<input class="CV" <?php if($editresult['leadpaxstatus']==1){ ?> checked="checked" <?php } ?> name="leadpaxstatus" id="leadpaxstatus" type="checkbox" style="margin-top: 10px;display:block;" value="1"/>
											</div>
										</label>
									</div>
								</td>
								<!--Ended age and lead pax person check -->


								<td width="20%" style="padding-right:10px;">
									<div class="griddiv">
										<label>
											<div class="gridlable">Anniversary Date</div>
											<input name="anniversaryDate" type="text" id="anniversaryDate" class="gridfield calfieldicon" autocomplete="off" value="<?php if ($editresult['anniversaryDate'] != '' && $editresult['anniversaryDate'] != '1970-01-01') { echo date("d-m-Y", strtotime($editresult['anniversaryDate'])); } ?> "  />
										</label>
									</div>
								</td>

							</tr>
						</table>
						
						<div>
							<h2 class="childinformation">Contact Information</h2>
						</div>
						<div></div>
						<div class="griddiv">
							<label>
								<div class="gridlable" style="width: 45% !important; display:inline-block;">&nbsp;
								Mobile / Landline &nbsp;&nbsp;&nbsp;&nbsp;Code   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Number</div>
								<div class="gridlable email-marg" style="width: 50% !important;">
								Email Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email Address</div>
<div id="loadphonenumber">
<?php
$phonen = 1;
$getphoneemail = "SELECT pM.phoneNo,pM.countryCode,pM.phoneType, pM.id as PID, eM.email, eM.emailType, eM.primaryvalue, eM.id as EID 
FROM emailMaster eM  
LEFT JOIN phoneMaster pM ON pM.EID = eM.id 
WHERE eM.masterId ='".$lastId."' AND pM.masterId ='".$lastId."' ORDER BY EID ASC ";

$queryb = mysqli_query(db(),$getphoneemail) or die(mysqli_error(db()));
if(mysqli_num_rows($queryb)>0){
	while ($resListing22 = mysqli_fetch_array($queryb)) { ?>
		<div id="phoneid<?php echo $phonen; ?>" >
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%" align="left">
						
						<input type="hidden" id="EID<?php echo $phonen; ?>" name="EID<?php echo $phonen; ?>" value="<?php echo $resListing22['EID'] ?>">
						<input type="hidden" id="PID<?php echo $phonen; ?>" name="PID<?php echo $phonen; ?>" value="<?php echo $resListing22['PID'] ?>">
						<select id="PhoneTypeId<?php echo $phonen; ?>" name="PhoneTypeId<?php echo $phonen; ?>" class="gridfield" autocomplete="off" style="padding: 9px; height: 37px;">
							<?php
							$select2 = '*';
							$where2 = ' status=1 order by id asc';
							$rs2 = GetPageRecord($select2, _PHONE_TYPE_MASTER_, $where2);
							while ($restype2 = mysqli_fetch_array($rs2)) {
							?>
								<option value="<?php echo strip($restype2['id']); ?>" <?php if ($restype2['id'] == $resListing22['phoneType']) { ?>selected="selected" <?php } ?>><?php echo strip($restype2['name']); ?></option>
							<?php } ?>
						</select>
					</td>

					<td width="0%" align="left">&nbsp;&nbsp;</td>
					<td width="" align="left" style="padding-right: 10px; width: 8%;">
					
					<?php 
					$rsn="";
					$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
					$cmpcountryData=mysqli_fetch_array($rs1cmp);
					$compcountryCode = $cmpcountryData['compcountryCode'];
					?>



					<input name="countryCode<?php echo $phonen; ?>" type="text" class="gridfield" id="countryCode<?php echo $phonen; ?>" placeholder="+91" 
					value="<?php if($resListing22['countryCode'] !=''){ echo $resListing22['countryCode']; }else{ echo '+'. $compcountryCode;}  ?>" maxlength="5" />
				
				</td>
					<td width="" align="left" style="padding-right: 10px;"><input name="PhoneNo<?php echo $phonen; ?>" type="text" class="gridfield" id="PhoneNo<?php echo $phonen; ?>" value="<?php echo $resListing22['phoneNo']; ?>" maxlength="12" /></td>

					<td width="15%" align="left"><select id="EmailTypeId<?php echo $phonen; ?>" name="EmailTypeId<?php echo $phonen; ?>" class="gridfield" autocomplete="off" style="padding: 9px; height: 37px;">
							<?php
							$select = '*';
							$where = ' status=1 order by id asc';
							$rs = GetPageRecord($select, _EMAIL_TYPE_MASTER_, $where);
							while ($restype = mysqli_fetch_array($rs)) {
							?>
							<option value="<?php echo strip($restype['id']); ?>" <?php if ($restype['id'] == $resListing22['emailType']) { ?> selected="selected" <?php } ?>><?php echo strip($restype['name']); ?></option>
							<?php } ?>
						</select></td>

					<td width="0%" align="left">&nbsp;&nbsp;</td>
					<td width="" align="left"> 

						<input name="Email<?php echo $phonen; ?>" type="email" class="<?php if($_REQUEST['guestList']==3 || $contactType == 3){ echo "gridfield"; }else{ echo "gridfield "; } ?>" displayname="Email" id="Email<?php echo $phonen; ?>" value="<?php echo $resListing22['email']; ?>" maxlength="100"/> 

					</td>

					<td width="3%" align="center">
						<div style="padding:3px 6px; font-size:12px; color:#009900;">
							<lable><input class="CV" name="primaryValue<?php echo $phonen; ?>" id="primaryValue<?php echo $phonen; ?>" type="checkbox" value="<?php echo $phonen; ?>" style="display:block;" <?php if ($resListing22['primaryvalue'] == 1) { ?>checked="checked" <?php } ?> onChange="removeChecked(<?php echo $phonen; ?>);"  />
							</lable>
						</div>
					</td>
					<td width="6%" align="center">
						<?php if ($phonen == 1) { ?>
							<img src="images/addicon.png" width="20" height="20" onclick="addphoneNumbers();" style="cursor:pointer;" />
						<?php } else { ?>
							<img src="images/deleteicon.png" onclick="removephoneNumbers(<?php echo $phonen; ?>,<?php echo $resListing22['EID']; ?>,<?php echo $resListing22['PID']; ?>);" style="cursor:pointer;" />
						<?php } ?>
					</td>
				</tr>
			</table>
		</div>
		<?php 
		$phonen++;
	} 
} 
if ($phonen == 1) { ?>
	<div id="phoneid1">
		<input type="hidden" id="EID" name="EID" value="0">
		<input type="hidden" id="PID" name="PID" value="0">
		<table width="" border="0" cellpadding="0" cellspacing="0">
			<tr>
			
				<td width="15%" align="left"><select id="PhoneTypeId1" name="PhoneTypeId1" class="mobile-mar gridfield validate " displayname="Mobile" autocomplete="off" style="padding: 9px; height: 37px;"> 
						<?php
						$select = '*';
						$where = ' status=1 order by id asc';
						$rs = GetPageRecord($select, _PHONE_TYPE_MASTER_, $where);
						while ($restype = mysqli_fetch_array($rs)) {
						?>
							<option value="<?php echo strip($restype['id']); ?>" <?php if ($restype['id'] == $reslisting22['phonetype']) { ?>selected="selected" <?php } ?>><?php echo strip($restype['name']); ?></option>
						<?php } ?>
					</select></td>
					<td width="55px;" align="left" >

					<?php 
$rsn="";
$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
$cmpcountryData=mysqli_fetch_array($rs1cmp);
$compcountryCode = $cmpcountryData['compcountryCode'];
?>

				<input name="countryCode1" type="text" class="gridfield validate contry-code" id="countryCode1" value="<?php echo '+'. $compcountryCode; ?>" displayname="Country Code" placeholder="+91">


			</td>
			<!-- hhhhhhhhhhhhhhhhhhhh -->
				<td width="0%" align="left">&nbsp;&nbsp;</td>
				<td width="" align="left" style="padding-right: 10px;"><input name="PhoneNo1" type="text" class="phone-marg gridfield " displayname="Mobile" id="PhoneNo1" value="<?php echo $phonenNew; ?>" maxlength="14" /></td>


				<td width="15%" align="left">
					<select id="EmailTypeId1" name="EmailTypeId1" class="gridfield" autocomplete="off" style="padding: 9px; height: 37px;">
					<?php
					$select = '*';
					$where = ' status=1 order by id asc';
					$rs = GetPageRecord($select, _EMAIL_TYPE_MASTER_, $where);
					while ($restype = mysqli_fetch_array($rs)) {
					?>
						<option value="<?php echo strip($restype['id']); ?>" <?php if ($restype['id'] == $reslisting['emailtype']) { ?>selected="selected" <?php } ?>><?php echo strip($restype['name']); ?></option>
					<?php } ?>
					</select></td>
				<td width="0%" align="left">&nbsp;&nbsp;</td>
				
				
				<td width="" align="left">
						<input name="Email1" type="email" class="<?php if($_REQUEST['guestList']==3 || $contactType == 3){ echo "gridfield"; }else{ echo "gridfield"; } ?>" displayname="Email" id="Email1" value="<?php echo $emailNew; ?>" maxlength="100" />
				</td>
				
				<td width="3%" align="center">
					<div style="padding:3px 6px; font-size:12px; color:#009900;">
						<lable><input class="CV"  name="primaryValue1" id="primaryValue1" type="checkbox" style="display:block;" value="1" checked="checked" onChange="removeChecked(1);"  />
						</lable>
					</div>
				</td>
				<td width="6%" align="center"><img src="images/addicon.png" width="20" height="20" onclick="addphoneNumbers();" style="cursor:pointer;" /></td>
			</tr>
		</table>
	</div>
	<?php 
} ?>
<input name="phonecount" type="hidden" id="phonecount" value="<?php if ($phonen == 1) { echo '1'; } else { echo ($phonen-1); } ?>" />
<div id="deletedocument"></div>
<script>
	function addphoneNumbers() {
		var phonecount = $('#phonecount').val();
		phonecount = Number(phonecount) + 1;
		$.get("loadphonenumber.php?id=" + phonecount, function(data) {
			$("#loadphonenumber").append(data);
		});
		$('#phonecount').val(phonecount);
	}

	function removephoneNumbers(id,EID,PID) {
		$('#phoneid' + id).remove();
		var phonecount = $('#phonecount').val();
		phonecount = Number(phonecount) - 1;
		$('#phonecount').val(phonecount);
		
		$('#deletedocument').load('frmaction.php?action=deleteB2CContactS&EID='+EID+'&PID='+PID+'');

	}
	function removeChecked(id) {
	   	var unchecking = document.getElementsByClassName("CV");
	   	for(var i=0; i<unchecking.length; i++){  
            if(unchecking[i].type=='checkbox') {
                unchecking[i].checked=false;  
            } 
        }
        // deSelect();
	   	document.getElementById("primaryValue"+id).checked = true;
	}

	function deSelect(){  
        var ele=document.getElementsByName('CV');  
        for(var i=0; i<ele.length; i++){  
            if(ele[i].type=='checkbox')  
                ele[i].checked=false;  
              
        }  
    }  
</script>
</div>

</label>

</div>

<!-- Address Information code started -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<h2 class="childinformation">Address Information</h2>
							</tr>
							<tr>
								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>
											<div class="gridlable">Country</div>
											<select id="country" name="country" class="gridfield" displayname="Country" autocomplete="off" onchange="getStateAllStates(this.value);">
												<option value="">Select</option>
												<?php


												// $rs1cmp22=GetPageRecord('*','companySettingsMaster','id=1');
												// $editresultcmp22=mysqli_fetch_array($rs1cmp22);
												// $nationalitycmp=clean($editresultcmp22['id']);
												// $nationalityId=clean($editresultcmp['nationality']);
												// $compcountryCode22=clean($editresultcmp22['compcountryCode']);




												// $countrycode = $compcountryCode;

												$DefaultCountry = 'India';
												$select1 = '';
												$wherec = '';
												$rsc = '';
												$select1 = '*';
												$wherec = ' deletestatus=0 order by name asc';
												$rsc = GetPageRecord($select1, 'countryMaster', $wherec);
												while ($coresListing = mysqli_fetch_array($rsc)) {

													// if ($editresult['countryId']>0) {
													// 	$isDefaultCountry = $editresult['countryId'];
													// } else {
													// 	$isDefaultCountry = $coresListing['setDefault'];
													// }
												?>
													<option value="<?php echo strip($coresListing['id']); ?>" <?php if($coresListing['id'] == $compcountryCode22){ ?>selected="selected" <?php }elseif($compcountryCode22==1){ echo 'selected'; } ?>><?php echo strip($coresListing['name']); ?></option>
												<?php } ?>
											</select>
										</label>
									</div>
								</td>

								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>

											<div class="gridlable">State</div>
											<select id="loadstates" name="loadstates" class="gridfield" displayname="State" autocomplete="off" onchange="getStateAllCities(this.value);">
												<option value="">Select</option>
												<?php

												$rstate = "";

												$rstate = GetPageRecord('*', _STATE_MASTER_, ' id="' . $editstateId . '" order by name asc');

												while ($stateData = mysqli_fetch_array($rstate)) {

												?>
													<option value="<?php echo strip($stateData['id']); ?>" selected="selected"><?php echo strip($stateData['name']); ?></option>

												<?php } ?>
											</select>
										</label>
									</div>
								</td>

								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>
											<div class="gridlable">City</div>
											<select id="loadcities" name="loadcities" class="gridfield" displayname="City" autocomplete="off">
												<option value="">Select</option>
												<?php
												$rstatess = "";

												$rstatess = GetPageRecord('*', _STATE_MASTER_, ' id="' . $editcityId . '" order by name asc');

												while ($statesData = mysqli_fetch_array($rstatess)) {

												?>
													<option value="<?php echo strip($statesData['id']); ?>"><?php echo strip($statesData['name']); ?></option>

												<?php } ?>
											</select>
										</label>
									</div>
								</td>

								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>
											<div class="gridlable">Pin/Zip</div>
											<input type="number" name="pinzip" id="pinzip" class="gridfield" value="<?php echo $editresult['pinCode']; ?>">
										</label>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="4" style="padding-right:10px;">
									<div class="griddiv"><label>
											<div class="gridlable">Address</div>
											<textarea name="addressInfo" id="addressInfo" rows="" style="width:98%; padding:5px; margin-top:3px;"><?php echo $editresult['address1']; ?></textarea>
										</label>
									</div>
								</td>
							</tr>
							
						</table>
						<!-- Address Information code ended -->
						<script>
							function defaultsateload(){
								var countryId = $('#country').val();
								if(countryId!=''){
									$('#loadstates').load('loadstatcity.php?action=loadallstates&countryId=' + countryId + '&selectIdst=<?php echo $editstateId; ?>');
								}
							}

							defaultsateload();
							function defualtcities(){
								var stateId = $('#loadstates').val();
								if(stateId!=''){
									$('#loadcities').load('loadstatcity.php?action=loadallCities&stateId=' + stateId + '&selectIdct=<?php echo $editcityId; ?>');
								}
							}
							defualtcities();

							function getStateAllStates(countaryId) {
								var countryId = $('#country').val();

								$('#loadstates').load('loadstatcity.php?action=loadallstates&countryId=' + countryId + '&selectIdst=<?php echo $editstateId; ?>');
							}



							function getStateAllCities(stateId) {
								var stateId = $('#loadstates').val();
								$('#loadcities').load('loadstatcity.php?action=loadallCities&stateId=' + stateId + '&selectIdct=<?php echo $editcityId; ?>');
							}

							<?php
							if ($_GET['id'] != '') {
							?>
								getStateAllStates();
								getStateAllCities();
							<?php } ?>
						</script>

						

					<!-- <i class="fa-solid fa-minus"></i> -->
					
					<td width="40%" align="left" valign="top" style="padding-left:20px;">
					
					<div id="minimizeDiv" onclick="minimizeDiv();" style="margin-top: -39px; padding-bottom: 10px;">
							<div style="cursor: pointer;font-size:20px; font-weight:500; "><span><i id="checkIcon1" class="fa-solid fa-plus" aria-hidden="true"></i> Add More Information</span></div>
						</div>
			

						<div style="display:block;" id="maximizeDiv">
							<?php if($_REQUEST['guestList']==3){ }else{ ?>
							<table width="50%" id="salesPersonId">
								<tr>
									<td width="20%" colspan="1">
										<div class="griddiv">
											<label>
												<div class="gridlable" id="assignToLable">Sales Person</div>
												<select id="assignTo" name="assignTo" class="gridfield" autocomplete="off" style="padding: 9px; height: 37px;">
													<option value="">Select</option>
													<?php
													$selects = '*';
													$whereS =' status=1 and deletestatus=0 and id!=37 order by firstName asc';
												$restypeSalesq = GetPageRecord($selects, _USER_MASTER_, $whereS);
												while ($restypeSales = mysqli_fetch_array($restypeSalesq)) {
													?>
														<option value="<?php echo encode($restypeSales['id']); ?>" <?php if ($restypeSales['id'] == $editassignTo) { ?>selected="selected" <?php } ?>><?php echo strip($restypeSales['firstName']) . ' ' . strip($restypeSales['lastName']); ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</td>
									<!-- <tr> -->
								<td width="30%">
								<div class="griddiv" style="margin-left: 20%;">
								<label>
								<div class="gridlable">status<span class="redmind"></span></div>
								<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off"   style="width: 100%;"> 	
								<option value="1" <?php if($editresult['status']=='1'){ ?>selected="selected"<?php } ?>>Active</option>
								<option value="0" <?php if($editresult['status']=='0'){ ?>selected="selected"<?php } ?>>In Active</option>
								</select></label>
								</div>
								</td>
							<!-- </tr> -->
									<td width="10%" id="empdesignationId" style="display: none;">
										<div class="griddiv">
											<label>
												<div class="gridlable" id="assignToLable">Designation</div>
												<input type="text" name="designationname" id="designationname" class="gridfield" value="<?php echo $editresult['designation']; ?>" displayname="Designation">
											</label>
										</div>
									</td>
								</tr>
							</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0" id="familyCodeDiv">
							<tr><td class="childinformation" style="padding-bottom: 15px; padding-top: 5px;">Family Information</td></tr>
								<tr>
									<td class="familytdwidth">
										<div class="griddiv"><label>
												<div class="gridlable">Family Code</div>
												<script>
													<?php $six_digit_random_number = mt_rand(100000, 999999); ?>

													function genratefamilycode() {
														var familyRelation = $('#familyRelation').val();
														if (familyRelation == 'Family Head') {
															var firstName = $('#firstName').val();
															var lastName = $('#lastName').val();


															var str = "",
																abbr = "";
															str = firstName + ' ' + lastName;
															str = str.split(' ');
															for (i = 0; i < str.length; i++) {
																abbr += str[i].substr(0, 1);
															}

															var fullname = abbr + <?php echo $six_digit_random_number; ?>;
															$('#familyCode').val(fullname);
														}
													}
												</script>

												<input name="familyCode" type="text" class="gridfield" id="familyCode" value="<?php if ($_REQUEST['fc'] != '') { echo $_REQUEST['fc']; } else { echo $editresult['familyCode']; } ?>" maxlength="250" />
											</label>
										</div>
									</td>

									<td style="padding-left:10px;" class="familytdwidth">
										<div class="griddiv"><label>
												<div class="gridlable">Family Relation </div>

												<select id="familyRelation" name="familyRelation" class="gridfield" displayname="family Relation" autocomplete="off" <?php if ($_REQUEST['fc'] == '') { ?>onchange="genratefamilycode();" <?php } ?>>
													<option value="">Select</option>
													<?php
													$select = '';
													$where = '';
													$rs = '';
													$select = '*';
													$where = ' 1 order by id asc';
													$rs = GetPageRecord($select, 'familyRelationMaster', $where);
													while ($resListing = mysqli_fetch_array($rs)) {
													?>
														<option value="<?php echo strip($resListing['name']); ?>" <?php if ($resListing['name'] == $editresult['familyRelation']) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
										<script>
											<?php
											$six_digit_random_number = mt_rand(100000, 999999); ?>

											function genratefamilycode() {
												var familyRelation = $('#familyRelation').val();
												if (familyRelation == 'Family Head') {
													var firstName = $('#firstName').val();
													var lastName = $('#lastName').val();
													var str = "",
														abbr = "";
													str = firstName + ' ' + lastName;
													str = str.split(' ');
													for (i = 0; i < str.length; i++) {
														abbr += str[i].substr(0, 1);
													}
													var fullname = abbr + <?php echo $six_digit_random_number; ?>;
													$('#familyCode').val(fullname);
												}
											}
										</script>
									</td>
								</tr>
							</table>
							<table width="100%" border="0" cellpadding="0" cellspacing="0" id="preferancesId">
								<tr><td class="childinformation" style="padding-bottom:15px;">Preference</td></tr>
								<tr>
								
									<td width="25%">
										<div class="griddiv"><label>
												<div class="gridlable">Meal Preference</div>

												<select id="mealPreference" name="mealPreference" class="gridfield" displayname="Meal Preference" autocomplete="off">
													<option value="">Select</option>
													<?php
													$select = '';
													$where = '';
													$rs = '';
													$select = '*';
													$where = ' 1 order by id asc';
													$rs = GetPageRecord($select, 'mealPreference', $where);
													while ($resListing = mysqli_fetch_array($rs)) {
													?>
														<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $mealPreference) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</td>
									<td width="25%" style="padding-left:10px;">
										<div class="griddiv"><label>
												<div class="gridlable">Special&nbsp;Assistance</div>

												<select id="physicalCondition" name="physicalCondition" class="gridfield" displayname="Physical Condition" autocomplete="off">
													<option value="">Select</option>
													<?php
													$select = '';
													$where = '';
													$rs = '';
													$select = '*';
													$where = ' 1 order by id asc';
													$rs = GetPageRecord($select, 'physicalCondition', $where);
													while ($resListing = mysqli_fetch_array($rs)) {
													?>
														<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $physicalCondition) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</td>
									<td width="25%" style="padding-left:10px;">
										<div class="griddiv"><label>
												<div class="gridlable">Seat&nbsp;Preference </div>

												<select id="seatPreference" name="seatPreference" class="gridfield" displayname="Seat Preference" autocomplete="off">
													<option value="">Select</option>
													<option value="Window Seat" <?php if ('Window Seat' == $seatPreference) { ?>selected="selected" <?php } ?>>Window Seat</option>
													<option value="Aisle" <?php if ('Aisle' == $seatPreference) { ?>selected="selected" <?php } ?>>Aisle</option>
												</select>
											</label>
										</div>
									</td>
									<td width="25%" style="padding-left:10px;">
										<div class="griddiv"><label>
												<div class="gridlable">Accomodation&nbsp;Preference </div>

												<select id="accomodationPreference" name="accomodationPreference" class="gridfield" displayname="Seat Preference" autocomplete="off">
													<option value="">Select</option>
													<?php
													$select = '';
													$where = '';
													$rs = '';
													$select = '*';
													$where = ' 1 order by id asc';
													$rs = GetPageRecord($select, _PRE_ACCOMODATION_MASTER_, $where);
													while ($resListing = mysqli_fetch_array($rs)) {
													?>
														<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $preAccomodationMaster) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</td>
								</tr>
							</table>
							<?php } ?>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<div>
										<h2 class="childinformation">Others</h2>
									</div>

									<script src="plugins/select2/select2.full.min.js"></script>
									<script>
										$(document).ready(function() {
											$('.select2').select2();
										});
									</script>

									<td>
										<div class="griddiv">
											<label>
												<div class="gridlable">Market&nbsp;Type</div>
												<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off">
													<?php
													$rs = GetPageRecord('*', 'marketMaster', ' deletestatus=0 and status=1 order by name asc');
													while ($resListing = mysqli_fetch_array($rs)) {
													?>
														<option value="<?php echo strip($resListing['id']); ?>" <?php if ($resListing['id'] == $editmarketType) { ?>selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</td>
									<td style="padding-left:10px;" width="35%">
										<div class="griddiv"><label>
												<div class="gridlable" style="overflow: visible;">Holiday&nbsp;Preference</div>

												<select id="preholydaypacs" name="preholydaypacs[]" multiple="multiple" class="gridfield select2" displayname="familyRelation" autocomplete="off" <?php if ($_REQUEST['fc'] == '') { ?>onchange="genratefamilycode();" <?php } ?> style="overflow: visible;">
													<option value="">Select</option>
													<?php
													$select = '';
													$where = '';
													$rs = '';
													$select = '*';
													$where = ' 1 order by id asc';
													$rs = GetPageRecord($select, _PREHOLIDAYPAC_MASTER_, $where);
													while ($resListing = mysqli_fetch_array($rs)) {
														$holyDayPacId = explode(',', $editresult['holyDayPacId']);
													?>
														<option value="<?php echo strip($resListing['id']); ?>" <?php foreach ($holyDayPacId as $val) {	if ($val == strip($resListing['id'])) { ?> selected="selected" <?php } } ?>><?php echo strip($resListing['name']); ?></option>
													<?php } ?>
												</select>
											</label>
										</div>
									</td>
									<td width="15%" style="padding-right: 10px; display: none;">
										<div class="griddiv"><label>
												<div class="gridlable">Mobile Pin</div>
												<input name="mobilePin" type="text" class="gridfield" id="mobilePin" value="<?php echo $mobilePin; ?>" />
											</label>
										</div>
									</td>
									<!-- new covid section added code started -->
									<?php if($_REQUEST['guestList']==3){ }else{ ?>
									<td width="20%" style="padding-right: 10px; ">
										<div class="griddiv"><label>
												<div class="gridlable">Covid Vaccinated</div>
												<select id="CovidVaccin" name="CovidVaccin" class="gridfield" displayname="CovidVaccin" autocomplete="off">
												<option value="No" <?php if ($editresult['CovidVaccin'] == 0) { ?> selected="selected" <?php } ?>>No</option>
												<option value="Yes" <?php if ($editresult['CovidVaccin'] == 1) { ?> selected="selected" <?php } ?>>Yes</option>
												</select>
											</label>
										</div>
									</td>
									<?php } ?>
									<!-- new covid section added code ended -->
									<?php if($_REQUEST['guestList']==3){ }else{ ?>
									<td width="30%" style="padding-right:10px;" id="newsLetterId">
										<div class="griddiv">
											<label>
												<div class="gridlable">Newsletter </div>
												<select id="Newsletter" name="Newsletter" class="gridfield" displayname="Newsletter" autocomplete="off">
													<option value="No" <?php if ($editresult['Newsletter'] == 0) { ?> selected="selected" <?php } ?>>No</option>
													<option value="Yes" <?php if ($editresult['Newsletter'] == 1) { ?> selected="selected" <?php } ?>>Yes</option>
												</select>
											</label>
										</div>
									</td>
									<?php } ?>
								</tr>

							</table>


							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<div>
										<h2 class="childinformation">Emergency Contact Details</h2>
									</div>
									<td width="33%" style="padding-right:10px;">
										<div class="griddiv"><label>
												<div class="gridlable">Name </div>
												<input name="emergencyName" type="text" class="gridfield" id="emergencyName" value="<?php echo $editresult['emergencyName']; ?>" maxlength="250" />
											</label>
										</div>
									</td>
									<td width="33%" style="padding-right:10px;">
										<div class="griddiv"><label>
												<div class="gridlable">Relation</div>
												<input name="emergencyRelation" type="text" class="gridfield" id="emergencyRelation" value="<?php echo $editresult['emergencyRelation']; ?>" maxlength="250" />
											</label>
										</div>
									</td>
									<td width="33%">
										<div class="griddiv"><label>
												<div class="gridlable">Contact&nbsp;Number </div>
												<input name="emergencyContact" type="text" class="gridfield" id="emergencyContact" value="<?php echo $editresult['emergencyContact']; ?>" maxlength="12" />
											</label>
										</div>
									</td>
								</tr>
							</table>
							
					</td>
				</tr>
			</table>
			<!-- Documentation section start -->
			<!-- <table width="80%">
				<tr> -->
				<div id="Documentationparent">
							<?php
							//$Documentation=1;
							?>

							<div>
								<h2 class="childinformation">Documentation</h2>
							</div>
							<div id="loadallDocument">
								<?php
								$Documentation = 1;
								$selectD = '';
								$whereD = '';
								$rsD = '';
								$selectD = '*';
								$whereD = ' masterId=' . $lastId . ' and sectionType="contacts" order by id asc';
								$rsD = GetPageRecord($selectD, 'documentMaster', $whereD);
								while ($resListingD = mysqli_fetch_array($rsD)) { ?>
									<div id="documentDiv<?php echo $Documentation; ?>">
										<table width="90%">
											<tr>

												<td width="10%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Document&nbsp;Type <span class="redmind"></span> </div>

															<input type="hidden" id="documentId<?php echo $Documentation; ?>" name="documentId<?php echo $Documentation; ?>" value="<?php echo $resListingD['id'] ?>">
															<select id="documentType<?php echo $Documentation; ?>" name="documentType<?php echo $Documentation; ?>" class="gridfield validate" displayname="Document Type" autocomplete="off">
																<option value="">Select</option>
																<option value="1" <?php if ($resListingD['docType'] == 1) { ?> selected="selected" <?php } ?>>Adhar Card</option>
																<option value="2" <?php if ($resListingD['docType'] == 2) { ?> selected="selected" <?php } ?>>Passport</option>
																<option value="3" <?php if ($resListingD['docType'] == 3) { ?> selected="selected" <?php } ?>>VISA</option>
																<option value="4" <?php if ($resListingD['docType'] == 4) { ?> 
																selected="selected" <?php } ?>>License</option>
																<option value="5" <?php if ($resListingD['docType'] == 5) { ?> selected="selected" <?php } ?>>Covid V Cert.</option>
																<option value="6" <?php if ($resListingD['docType'] == 6) { ?> selected="selected" <?php } ?>>Other</option>
															</select>
														</label>
													</div>
												</td>
												<td style="width: 9%;">
												<div class="griddiv"><label>
															<div class="gridlable">Required <span class="redmind"></span> </div>
													<select name="documentRequired<?php echo $Documentation; ?>" id="documentRequired<?php echo $Documentation; ?>" class="gridfield validate">
														<option value="Yes" <?php if ($resListingD['docRequired'] === 'Yes') { ?> selected="selected" <?php } ?>>Yes</option>
														<option value="No" <?php if ($resListingD['docRequired'] === 'No') { ?> selected="selected" <?php } ?>>No</option>
													</select>
													</label>
												</div>
												</td>
												<td width="14%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Document&nbsp;No. <span class="redmind"></span> </div>
															<input type="text" id="documentNumber<?php echo $Documentation; ?>" name="documentNumber<?php echo $Documentation; ?>" class="gridfield validate" displayname="Document Number" autocomplete="off" value="<?php echo $resListingD['documentNo']; ?> ">
														</label>
													</div>
												</td>

												<td width="12%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Issue&nbsp;Date <span class="redmind"></span> </div>
															<input type="text" id="issueDate<?php echo $Documentation; ?>" name="issueDate<?php echo $Documentation; ?>" class="gridfield calfieldicon validate" displayname="Issue Date" autocomplete="off" value="<?php if ($resListingD['issueDate'] != '') { echo date("d-m-Y", strtotime($resListingD['issueDate'])); } ?> ">
														</label>
													</div>
												</td>

												<td width="12%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Expiry&nbsp;Date <span class="redmind"></span> </div>
															<input type="text" id="expiryDate<?php echo $Documentation; ?>" name="expiryDate<?php echo $Documentation; ?>" class="gridfield calfieldicon validate" displayname="Expiry Date" autocomplete="off" value="<?php if ($resListingD['expiryDate'] != '') { echo date("d-m-Y", strtotime($resListingD['expiryDate'])); } ?>">
														</label>
													</div>
												</td>

												<td width="13%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Issue&nbsp;Country <span class="redmind"></span></div>
															<select id="issueCountry<?php echo $Documentation; ?>" name="issueCountry<?php echo $Documentation; ?>" class="gridfield validate" displayname="Issue Country" autocomplete="off">
																<option value="">Select</option>
																<?php

																$wherissue = ' deletestatus=0 order by name asc';
																$resiss = GetPageRecord('*', 'countryMaster', $wherissue);
																while ($issueListing = mysqli_fetch_array($resiss)) {
																?>
																	<option value="<?php echo strip($issueListing['id']); ?>" <?php if ($issueListing['id'] == $resListingD['countryId']) { ?>selected="selected" <?php } ?>><?php echo strip($issueListing['name']); ?></option>
																<?php } ?>
															</select>
														</label>
													</div>
												</td>
											
												<td style="width: 12%;">
												<div class="griddiv"><label>
															<div class="gridlable">Document&nbsp;Title <span class="redmind"></span> </div>
															<select name="documenttitle<?php echo $Documentation; ?> " id="documenttitle<?php echo $Documentation; ?>" class="gridfield" onchange="Documentsides();">
																	
																<option value="1" <?php if($resListingD['documentTitle']=='1'){ ?> selected="selected" <?php } ?> >Both</option>
																<option value="2" <?php if($resListingD['documentTitle']=='2'){ ?> selected="selected" <?php } ?> >Front</option>
																<option value="3" <?php if($resListingD['documentTitle']=='3'){ ?> selected="selected" <?php } ?> >Back</option>

															</select>
														
															</label>
												</div>
												</td>
												<td width="20%" class="tdwidth" colspan="3">
													<div class="griddiv"><label>

															<div class="gridlable">Upload Document<span class="redmind"></span> </div>
															<input type="file" id="uploadDocument<?php echo $Documentation; ?>" name="uploadDocument<?php echo $Documentation; ?>" class="gridfield" displayname="Upload Document" autocomplete="off" value="<?php echo $resListingD['documentAttachment']; ?> ">

															<input type="hidden" id="uploadoldDocument<?php echo $Documentation; ?>" name="uploadoldDocument<?php echo $Documentation; ?>" class="gridfield" displayname="Upload Document" autocomplete="off" value="<?php echo $resListingD['documentAttachment']; ?> ">
														</label>
													</div>
												</td>

												<td align="center">
													<?php if ($Documentation == 1) { ?>
														<img src="images/addicon.png" width="20" height="20" onclick="addDocumentDetails();" style="cursor:pointer;" />
													<?php } else { ?>
														<img src="images/deleteicon.png" onclick="removedocumentation(<?php echo $Documentation; ?>);" style="cursor:pointer;" />
													<?php } ?>
												</td>
												</tr>
											
										</table>
									</div>
									<script>
										$(function() {
											$("#issueDate<?php echo $Documentation; ?>").Zebra_DatePicker({
												format: 'd-m-Y', //Ensures format consistency
												// onSelect: function() {
												// 	updateDates(this.id);
												// }

											});
										});

										$(function() {
											$("#expiryDate<?php echo $Documentation; ?>").Zebra_DatePicker({
												format: 'd-m-Y', //Ensures format consistency
												// onSelect: function() {
												// 	updateDates(this.id);
												// }

											});
										});
									</script>
								<?php
									$Documentation++;
								}

								?>

								<?php if ($Documentation == 1) { ?>
									<div id="documentDiv1">
										<table width="90%">
											<tr>

												<td width="10%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Document&nbsp;Type </div>
															<select id="documentType1" name="documentType1" class="gridfield" displayname="Document Type" autocomplete="off">
																<option value="">Select</option>
																<option value="1">Adhar Card</option>
																<option value="2">Passport</option>
																<option value="3">VISA</option>
																<option value="5">Covid V Cert.</option>
																<option value="6">Other</option>
															</select>
														</label>
													</div>
												</td>

												<td style="width: 9%;">
												<div class="griddiv"><label>
															<div class="gridlable">Required</div>
													<select name="documentRequired1" id="documentRequired1" class="gridfield ">
														<option value="Yes">Yes</option>
														<option value="No">No</option>
													</select>
													</label>
												</div>
												</td>

												<td width="14%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Document&nbsp;No.</div>
															<input type="text" id="documentNumber1" name="documentNumber1" class="gridfield" displayname="Document Number" autocomplete="off" value="<?php $resListingD['documentNo'] ?> ">
														</label>
													</div>
												</td>

												<td width="12%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Issue&nbsp;Date</div>
															<input type="text" id="issueDate1" name="issueDate1" class="gridfield calfieldicon" displayname="Issue Date" autocomplete="off" value=" <?php if ($editresult['issueDate'] != '') { echo date("d-m-Y", strtotime($editresult['issueDate'])); } ?> " onchange="updateDates();">
														</label>
													</div>
												</td>

												<td width="12%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Expiry&nbsp;Date</div>
															<input type="text" id="expiryDate1" name="expiryDate1" class="gridfield calfieldicon" displayname="Expiry Date" autocomplete="off" value="<?php if ($editresult['expiryDate'] != '') {echo date("d-m-Y", strtotime($editresult['expiryDate'])); } ?>" onchange="updateDates();">
														</label>
													</div>
												</td>

												<td width="13%" class="tdwidth">
													<div class="griddiv"><label>
															<div class="gridlable">Issue&nbsp;Country</div>
															<select id="issueCountry1" name="issueCountry1" class="gridfield" displayname="Issue Country" autocomplete="off">
																<option value="">Select</option>
																<?php

																$wherissue = ' deletestatus=0 order by name asc';
																$resiss = GetPageRecord('*', 'countryMaster', $wherissue);
																while ($issueListing = mysqli_fetch_array($resiss)) {
																?>
																	<option value="<?php echo strip($issueListing['id']); ?>" <?php if ($issueListing['id']) { ?>selected="selected" <?php } ?>><?php echo strip($issueListing['name']); ?></option>
																<?php } ?>
															</select>
														</label>
													</div>
												</td>
											
											<td style="width: 12%;">
												<div class="griddiv"><label>
															<div class="gridlable">Document&nbsp;Title</div>
															<select name="documenttitle1" id="documenttitle1" class="gridfield">
																<option value="1">Both</option>
																<option value="2">Front</option>
																<option value="3">Back</option>
															</select>
														
															</label>
												</div>
												</td>
											<td width="20%" class="tdwidth" colspan="3">
													<div class="griddiv"><label>
															<div class="gridlable">Upload Document</div>
															<input type="file" id="uploadDocument1" name="uploadDocument1" class="gridfield" displayname="Upload Document" autocomplete="off">
														</label>
													</div>
												</td>
												<!-- <td width="20%" class="tdwidth" colspan="3" id="frontside" style="display: none;">
													<div class="griddiv"><label>
															<div class="gridlable">Upload Front<span class="redmind"></span> </div>
															<input type="file" id="uploadDocument1" name="uploadDocument1" class="gridfield" displayname="Upload Document" autocomplete="off">
														</label>
													</div>
												</td>
												<td width="20%" class="tdwidth" colspan="3" id="backside" style="display: none;">
													<div class="griddiv"><label>
															<div class="gridlable">Upload Back<span class="redmind"></span> </div>
															<input type="file" id="uploadDocument1" name="uploadDocument1" class="gridfield" displayname="Upload Document" autocomplete="off">
														</label>
													</div>
												</td> -->
												<td align="center"><img src="images/addicon.png" width="20" height="20" onclick="addDocumentDetails();" style="cursor:pointer;" /></td>
											</tr>
										</table>
									</div>
								<?php } ?>
								<input name="documentcount" type="hidden" id="documentcount" value="<?php if ($Documentation == 1) {echo '1'; } else { echo $Documentation; } ?>" />
							</div>
							<!-- new code added social media code started -->
							<?php if($_REQUEST['guestList']==3){ }else{ ?>
							<table width="88%" border="0" cellpadding="0" cellspacing="0" id="socilMediaId">
								<tr>
									<div>
										<h2 class="childinformation">Social Media</h2>
									</div>
									<td width="10%" style="padding-right:10px;">
										<div class="griddiv"><label>
												<div class="gridlable">Facebook Profile</div>
												<input name="facebook" type="text" class="gridfield" id="facebook" value="<?php echo $editfacebook; ?>" maxlength="250" />
											</label>
										</div>
									</td>
									<td width="10%" style="padding-right:10px;">
										<div class="griddiv"><label>
												<div class="gridlable">Twitter Profile</div>
												<input name="twitter" type="text" class="gridfield" id="twitter" value="<?php echo $edittwitter; ?>" maxlength="250" />
											</label>
										</div>
									</td>
									<td width="10%" style="padding-right:10px;">
										<div class="griddiv leftmove"><label>
												<div class="gridlable">LinkedIn Profile</div>
												<input name="linkedIn" type="text" class="gridfield" id="linkedIn" value="<?php echo $editlinkedIn; ?>" maxlength="250" />
											</label>
										</div>
									</td>
								<!-- </tr>
								<tr> -->
									<td width="10%" style="padding-right:10px;">
										<div class="griddiv rightmove"><label>
												<div class="gridlable">Instagram Profile</div>
												<input name="Instagram" type="text" class="gridfield" id="Instagram" value="<?php echo $editresult['Instagram']; ?>" maxlength="250" />
											</label>
										</div>
									</td>

									<td width="10%" style="padding-right:10px;">
										<div class="griddiv rightmove"><label>
												<div class="gridlable">Skype ID</div>
												<input name="SkypeId" type="text" class="gridfield" id="SkypeId" value="<?php echo $editresult['SkypeId']; ?>" maxlength="250" />
											</label>
										</div>
									</td>

									<td width="10%" style="padding-right:10px;">
										<div class="griddiv leftmove"><label>
												<div class="gridlable">MSN ID</div>
												<input name="MSNId" type="text" class="gridfield" id="MSNId" value="<?php echo $editresult['MSNId']; ?>" maxlength="250" />
											</label>
										</div>
									</td>
								</tr>
							</table>
								<?php } ?>
							<!-- new code added social media code ended  -->
							<div class="griddiv"><label>
									<div class="gridlable">Remarks 1 </div>
									<textarea name="Remarks1" id="Remarks1" cols="178" rows="" class="remrks"><?php echo $editremark1; ?></textarea>

									<!-- <input  type="text" class="gridfield" id="address1" value="" maxlength="250" /> -->
								</label>
							</div>

							<div class="griddiv"><label>
									<div class="gridlable">Remarks 2 </div>
									<textarea name="Remarks2" id="Remarks2" cols="178" rows="" class="remrks"><?php echo $editresult['remark2']; ?></textarea>

								</label>
							</div>

							<div class="griddiv"><label>
									<div class="gridlable">Remarks 2 </div>
									<textarea name="Remarks3" id="Remarks3" cols="178" rows="" class="remrks"><?php echo $editresult['remark3']; ?></textarea>

								</label>
							</div>

						</div>


					</td>
					<div id="loaddocmentIddiv"></div>
					<script>
						function addDocumentDetails() {
							var documentdetail = $('#documentcount').val();
							documentdetail = Number(documentdetail) + 1;
							$.get("loadDocumentation.php?id=" + documentdetail, function(data) {
								$("#loadallDocument").append(data);
							});
							$('#documentcount').val(documentdetail);
							$
						}

						function removedocumentation(id) {

							$('#documentDiv' + id).remove();
							var documentdetail = $('#documentcount').val();
							documentdetail = Number(documentdetail) - 1;
							$('#documentcount').val(documentdetail);
							var documentId = $("#documentId<?php echo $Documentation; ?>").val();
							$("#loaddocmentIddiv").load('frmaction.php?action=deleteb2cContacts&documentId=' + id)
						}
					</script>
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
					<script>
						// $(document).ready(function(){
						// 	$('#minimizeDiv').click(function(){



						// });
						// });

						function minimizeDiv() {
							var className = $('#checkIcon1').attr('class');
							if (className === 'fa-plus') {
								$("#checkIcon1").removeClass("fa-plus");
								$("#checkIcon1").addClass('fa-minus');
							}
							if (className === 'fa-minus') {
								$("#checkIcon1").removeClass("fa-minus");
								$("#checkIcon1").addClass('fa-plus');
							}
							$('#maximizeDiv').toggle();
						}
					</script>
				<!-- </tr>
			</table> -->
			<!-- Docmentation sect end -->
		</div>
		<div class="rightfootersectionheader">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="right">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><input name="editId" type="hidden" id="editId" value="<?php echo encode($lastId); ?>" />
									<?php
									if ($_GET['id'] != '') {
									?>
										<input name="editedityes" type="hidden" id="editedityes" value="1" />
									<?php } ?>
								</td>
								<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
								<td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn" onclick="formValidation('addeditfrm','submitbtn','1');" /></td>
								<td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
							</tr>
		</div>
		</table>
		</td>
		</tr>

		</table>
</div>

</form>

</div>



<script>

	function selectGuest(title,firstName,middleName,lastName,gender,birthDate,anniversaryDate,phone,email,age,nationality,country,state,city,zip,address,emergencyName,emergencyRelation,emergencyContact,familyCode,familyRelation){

			$("#contacttitleId").val(title);
			$("#firstName").val(firstName);
			$("#middleName").val(middleName);
			$("#lastName").val(lastName);
			$("#gender").val(gender);
			$("#birthDate").val(birthDate);
			$("#anniversaryDate").val(anniversaryDate);
			$("#guestAge").val(age);
			$("#PhoneNo1").val(phone);
			$("#Email1").val(email);
			$("#nationality").val(nationality);
			$("#country").val(country);
			$("#loadstates").val(state);
			$("#loadcities").val(city);
			$("#pinzip").val(zip);
			$("#addressInfo").val(address);
			$("#emergencyName").val(emergencyName);
			$("#emergencyRelation").val(emergencyRelation);
			$("#emergencyContact").val(emergencyContact);
			$("#familyCode").val(familyCode);
			$("#familyRelation").val(familyRelation);

			$(".selectGuestbc").hide();
			$("#getbcguestName").hide();

	}

		$(document).click(function (e) {
			if ($(e.target).parents("#getbcguestName").length === 0) {
				$("#getbcguestName").hide();
			}
		});



	$(function() {

		$("#anniversaryDate").Zebra_DatePicker({
			format: 'd-m-Y', //Ensures format consistency
			onSelect: function() {
				updateDates(this.id);


			}


		});
	});

	$(function() {
		$("#issueDate1").Zebra_DatePicker({
			format: 'd-m-Y', //Ensures format consistency, #issueDate1, #expiryDate1
			// onSelect: function() {
			// 	updateDates(this.id);


			// }


		});
	});
	$(function() {
		$("#expiryDate1").Zebra_DatePicker({
			format: 'd-m-Y', //Ensures format consistency, #issueDate1, #expiryDate1
			// onSelect: function() {
			// 	updateallDates(this.id);


			// }


		});
	});


	comtabopenclose('linkbox', 'op2');
</script>
<style>

	.selectGuestbc{
	margin-bottom: 5px;
    border-bottom: 2px solid #ccc;
    padding: 5px 5px;
	cursor: pointer;
	}

	.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
		width: 100% !important;
	}

	.gridlable {
		width: 100% !important;
	}

	.addeditpagebox {
		padding: 20px !important;
	}

	.rightfootersectionheader {
		position: fixed !important;
		bottom: 0px !important;
	}
	.contry-code{
		padding: 9px!important;
		margin-left: 7px;

	}
	.mobile-mar{
		margin-left: 3px!important;
	}
	.email-marg{
		margin-left: 30px;
	}
	.phone-marg{
		margin-left: 6px;
	}
</style>