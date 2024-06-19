<?php
if($addpermission!=1 && $_REQUEST['id']==''){
	header('location:'.$fullurl.'');
}
if($editpermission!=1 && $_REQUEST['id']!=''){
	header('location:'.$fullurl.'');
}
if($_REQUEST['id']==''){
	$wheredel='addedBy='.trim($_SESSION['userid']).' and deletestatus=1';
	deleteRecord(_QUERY_MASTER_,$wheredel);
	$dateAdded=time();
	$namevalue ='deletestatus=1,moduleType=5,addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';
	$lastQueryId = addlistinggetlastid(_QUERY_MASTER_,$namevalue);
}
if($_REQUEST['id']!=''){
	$id=clean(decode($_REQUEST['id']));
	$select1='*';
	$where1='id='.$id.'';
	$rs1=GetPageRecord($select1,_QUERY_MASTER_,$where1);
	$editresult=mysqli_fetch_array($rs1);

	$editopsPersonId=clean($editresult['assignTo']);
	$editcompanyId=clean($editresult['companyId']);
	$editqueryDate=clean($editresult['queryDate']);
	$edittravelDate=clean($editresult['travelDate']);
	// $editfromDate = clean($editresult['fromDate']);
	// $edittoDate = clean($editresult['toDate']);
	// $editnight = clean($editresult['night']);
	// $objec=date_diff(date_create($editfromDate),date_create($edittoDate));
	// if($editnight < 1){
	// 	$editnight = $objec->format("%a");
	// }
	$editofficeBranch=clean($editresult['officeBranch']);
	$destinationId=clean($editresult['destinationId']);
	$dayWise=clean($editresult['dayWise']);
	$editadult=clean($editresult['adult']);
	$editchild=clean($editresult['child']);
	
	$edittourType=clean($editresult['tourType']);
	$editdescription=stripslashes($editresult['description']);
	$editleadPaxName=clean($editresult['leadPaxName']); 
	$editcategoryId=clean($editresult['categoryId']);
	$needFlight=clean($editresult['needFlight']);
	$earlyCheckin=clean($editresult['earlyCheckin']);
	$budgetCost=clean($editresult['expectedSales']); //query for edit here

	$editqueryCloseDetails=clean($editresult['queryCloseDetails']);
	$editqueryCloseDate=clean($editresult['queryCloseDate']);
	$editmultiemails=clean($editresult['multiemails']);
	$editqueryStatus=clean($editresult['queryStatus']);
	$quotationYes=clean($editresult['quotationYes']);
	$editattachmentFileclean=($editresult['attachmentFile']);
	$editremark=clean($editresult['remark']);
	$editqueryId=clean($editresult['queryId']);
	$editsubject=clean($editresult['subject']); 
	$needFlight=clean($editresult['needFlight']);
	$hotelCategory=clean($editresult['hotelCategory']);
	$cabforLocal=clean($editresult['cabforLocal']);
	$fromdestinationId=clean($editresult['fromdestinationId']);
	$addedBy=clean($editresult['addedBy']);
	$dateAdded=clean($editresult['dateAdded']);
	$guest1phone=clean($editresult['guest1phone']);
	$guest1email=clean($editresult['guest1email']);
	$modifyBy=clean($editresult['modifyBy']);
	$modifyDate=clean($editresult['modifyDate']); 
	$clientType=$editresult['clientType'];
	$seasonType = $editresult['seasonType'];
	$lastQueryId=$editresult['id'];
	$displayId=$editresult['displayId'];
	
	$multiemails=$editresult['multiemails'];
	$paxType=$editresult['paxType'];
	$rooms=$editresult['rooms'];
	$edithotelBudget=$editresult['hotelBudget'];
	$expectedSales=$editresult['expectedSales'];
	$leadsource=$editresult['leadsource'];
	$campaign=$editresult['campaign'];
	$competitor=$editresult['competitor'];
	$subDestination=$editresult['subDestination'];
	$single=$editresult['single'];
	$doubleocp=$editresult['doubleocp'];
	$triple=$editresult['triple'];
	$infant = $editresult['infant'];
	$queryType = $editresult['queryType'];
	$age1 = clean($editresult['age1']);
	$age2 = clean($editresult['age2']);
	$age3 = clean($editresult['age3']);
	$referanceno = clean($editresult['referanceno']);
	$filecode = clean($editresult['filecode']);
	$additionalInfo = clean($editresult['additionalInfo']);
	
	$editagentDivision = clean($editresult['agentDivision']);
	$editagentDesignation = clean($editresult['agentDesignation']);
	 
	$drs=GetPageRecord('name,id','nationalityMaster','1 and id="'.$editresult['nationality'].'"');
	$nationName=mysqli_fetch_array($drs);
	$nationality = $nationName['name'];
	$nationId = $nationName['id'];
	$drs=GetPageRecord('name,id','marketMaster','1 and id="'.$editresult['marketType'].'"');
	$nationName=mysqli_fetch_array($drs);
	$marketType = $nationName['name'];
	$marketId = $nationName['id'];
	
}
if($_REQUEST['id']==''){
	$clientType='1'; 
}
?>
<style>
.gridlable{width:100% !important;}
</style>
<div id="waitloaddest" style="display:none; top: 0px; left: 0px; background-color: #cccccc61; z-index: 9999; position: absolute; height: 100%; width: 100%;"><div style="width: 200px; margin: auto; margin-top: 14%; text-align: center; background-color: #fff; padding: 30px; border-radius: 4px; box-shadow: 0px 0px 5px #898484;">Please wait...</div></div>
<div class="rightsectionheader">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<div class="headingm" style="margin-left:20px;display:nones;"><span id="topheadingmain">
			<?php if($_REQUEST['id']!=''){ ?>Update <?php } else { ?>Add <?php }  echo $pageName; ?> </span>
			</div>
		</td>
		<td align="right">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="$('#loadQueryPackage').html('');formValidation('addeditquery','submitbtn','0');" /></td>
			<td><input type="button" name="Submit3" value="Save and New" class="whitembutton submitbtn"onclick="$('#loadQueryPackage').html('');formValidation('addeditquery','submitbtn','1');"/></td>
			<td style="padding-right:20px;">
				<input type="button" name="Submit22" value="Cancel" class="whitembutton" onclick="cancel();"  />
			</td>
		</tr>
	</table></td>
</tr>
</table>
</div>

<!-- main page body -->
<div id="pagelisterouter" style="padding-left:0px;margin-top: -20px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">
<div class="addeditpagebox" style=" margin-top: 20px; ">
	<!--hidden inputs-->
	<input name="action" type="hidden" id="action" value="<?php if($_REQUEST['id']!=''){ echo 'editdocket';} else { echo 'adddocket'; } ?>" />
	<input name="savenew" type="hidden" id="savenew" value="0" />
	<input name="paxType" type="hidden" id="paxType" value="2" />

	<input type="hidden" name="quotationYes" value="2"/>
	<input type="hidden" name="moduleType" value="5"/>
	<input type="hidden" name="attachitinerary" value="1"/>

	<input type="hidden" name="dayWise" id="dayWise" value="1">

	<input name="editId" id="editId" type="hidden" value="<?php if($lastQueryId!=''){ echo encode($lastQueryId); } ?>" />
	<input name="mailId" type="hidden" value="<?php echo decode($_REQUEST['incomingid']); ?>" />

 
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="60%" align="left" valign="top" style="padding-right:20px;">
				<!-- <div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;">Client Information </div> -->
				<div style="padding:10px;border:1px #ccc solid; display:block; " >
					<table border="0" cellpadding="0" cellspacing="0" <?php if($_REQUEST["id"]!= ""){?> style="display:nones;" <?php } ?>>
					<tr>
						<td width="20%" align="left" valign="top">
							<div class="griddiv">
								<div class="gridlable">Date </div>
								<input name="queryDate2" type="text" id="fromDate1" class="gridfield calfieldicon" displayname="query Date" autocomplete="off" value="<?php if($editqueryDate!='1970-01-01' && $editqueryDate != '0000-00-00'  && $editqueryDate != '' ){ echo date('d-m-Y',strtotime($editqueryDate)); }else{ echo date('d-m-Y'); } ?>" readonly="readonly" style="position: relative; top: auto; right: auto; bottom: auto; left: auto;">
							</div>
						</td>
						<td align="left" valign="top">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td width="20%" align="left" valign="top">
							<?php if($displayId>0){ ?>
							<div class="griddiv">
								<div class="gridlable">Docket Id </div>
								<input  type="text" class="gridfield " autocomplete="off" value="<?php echo makeDocketId($displayId); ?>" readonly="readonly">
							</div>
							<?php } ?>
						</td>
						<td width="45%">
						</td>
					</tr>
						<script type="text/javascript">
							// comtabopenclose('linkbox','op2');
							// function changenights(){
							// 	var f = $('#fromDate2').val();
							// 	if(f == '' || f == undefined){
							// 		$('#fromDate2').val('<?php echo date('d-m-Y'); ?>');
							// 		var someDate = new Date('<?php echo date('Y-m-d'); ?>');
							// 	}else{
							// 		var date_string = f.split("-").reverse().join("-");
							// 		var someDate = new Date(date_string);
							// 	}
							// 	var night = Number($('#night2').val());
							// 	someDate.setDate(someDate.getDate() + night);
							// 	someDate.setTime(someDate.getTime() + (330 * 60 * 1000));
							// 	var dateFormated = someDate.toISOString().substr(0,10);
							// 	var findate = dateFormated.split("-").reverse().join("-");
							// 	$('#toDate2').val(findate);
							// 	$('#counttnights').val(night);
							// }
							// $('#toDate2').Zebra_DatePicker({
							// 	format: 'd-m-Y',
							// 	onSelect: function (dateStr) {
							// 		var fromDate = $('#fromDate2').val().split("-").reverse().join("-");
							// 		var toDate = $('#toDate2').val().split("-").reverse().join("-");
							// 		var totaldays = showDays(toDate,fromDate);
							// 		if(totaldays > 0){
							// 			$('#night2').val(totaldays);
							// 		}
							// 	}
							// });
							// $('#fromDate2').Zebra_DatePicker({
							// 	direction: true,
							// 	format: 'd-m-Y',
							// 	pair: $('#toDate2')
							// }); 
						</script>
					</table>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" ">
						<tr>
							<td width="15%">
								<div class="griddiv">
									<label>
										<div class="gridlable" style="margin-top: 0px;">Business Type<span class="redmind"></span></div>
										<select id="clientType" name="clientType" class="gridfield validate" displayname="Client Type" onchange="selectclienttypename();" autocomplete="off">
											<?php
											$rs='';
											$rs=GetPageRecord('*','businessTypeMaster',' deletestatus=0 and status=1 order by name asc');
											while($resListing1=mysqli_fetch_array($rs)){
											?>
											<option value="<?php echo strip($resListing1['id']); ?>" <?php if($resListing1['id']==$clientType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing1['name']); ?></option>
											<?php } ?>
										</select>
									</label>
								</div>
							</td>
							<td width="40%">
								<div class="griddiv" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>; overflow:visible;"><img src="images/companyicon.png" width="30" height="30" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="openselectCompanypop();" />
									<label>
										<?php
										// Condition changed here ====================================================================
										if($clientType==2 && $editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){
												$select2='*';
												$where2='id='.$editcompanyId.'';
												$rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2);
												$contantnamemain=mysqli_fetch_array($rs2);
												$clientnemdisplay = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
												$clientnem = $contantnamemain['firstName'].' '.$contantnamemain['lastName'];
												$getphone =  getPrimaryPhone($contantnamemain['id'],'contacts');
												$getemail =  getPrimaryEmail($contantnamemain['id'],'contacts');
										}elseif($editcompanyId!='' && $editcompanyId!='0' && $_REQUEST['incomingid']==''){
												$select2='*';
												$where2='id='.$editcompanyId.'';
												$rs2=GetPageRecord($select2,_CORPORATE_MASTER_,$where2);
												$contantnamemain=mysqli_fetch_array($rs2);
												$clientnem = getCorporateCompany($editcompanyId);
												$clientnemdisplay = getPrimaryNameCompany($editcompanyId,"corporate");
												$getemail = getPrimaryEmailCompany($editcompanyId,"corporate");
												$getphone = getPrimaryPhoneCompany($editcompanyId,"corporate");
												$editcompanyId=($editcompanyId);
										}
										?>
										<div class="gridlable"><c id="agentTypeDiv">Name</c><span class="redmind"></span></div>
										<div style="width:100%; position:relative;">
											<?php if($profileeeDataaaaa['agentOption']==1){ ?>
											<div id="selectclientbox" style="padding:10px; background-color:#009900; color:#fff; position:absolute; right:1px; top:4px; cursor:pointer;" onclick="addclientfromquery();">Add New</div>
											<?php } ?>
											<input name="companyName" type="text" class="gridfield validate" id="companyName" value="<?php echo $clientnem; ?>"   displayname="Company" autocomplete="off"  onkeydown="searchcompanynamefuncCompany();" onkeyup="searchcompanynamefuncCompany();" />
											
											<div id="getDocketCompanyName" style="display:none;position: absolute; background-color: #f5f5f5; border: 1px solid #ccc; z-index: 99; top: 39px; left: 0px; width: 100%; overflow: auto; max-height: 240px; box-shadow: 2px 2px 7px #0000003d;"></div>
										</div>
										<script>
											function openselectCompanypop(){
												var clientType1 = $('#clientType').val();
												var incoming_query_email = '<?php echo $query_email; ?>';
												var incoming_query_mobile = '<?php echo $query_mobile; ?>';
												alertspopupopen('action=selectCorporate&clientType='+clientType1+'&incoming_query_email='+incoming_query_email+'&incoming_query_mobile='+incoming_query_mobile+'','600px','auto');
											}
											function addclientfromquery(){
												$('#getDocketCompanyName').hide();
												$('#selectclientbox').hide();
												$('#companyName').removeAttr('onkeydown');
												$('#companyName').removeAttr('onkeyup');
												$('#companyName').addClass('validate');
												$('#agentb2cname').addClass('validate');
												$('#agentb2cmail').addClass('validate');
												$('#marketType').removeAttr('readonly');
												$('#marketType').addClass('validate');
												$('#nationality').removeAttr('readonly');
												$('#nationality').addClass('validate');
												$('#addnewcontactmain').val('1');
											}
											function searchcompanynamefuncCompany(){
												var searchcompanyname = encodeURIComponent($('#companyName').val());
												var clientType = encodeURIComponent($('#clientType').val());
												if(clientType!='' && clientType!='0'){
													$('#getDocketCompanyName').load('getDocketCompanyName.php?clientType='+clientType+'&searchcompanyname='+searchcompanyname);
												}
												$('#getDocketCompanyName').show();
											}
											function selectCorporateCompany(name,email,contactPName,phone,id,opsPerson,opsPersonId,nationality,language,salesPerson,marketType,nationId,marketId,tourType,divisionId,designationName){
												$('#subject').val('<?php echo date('d-m-Y'); ?> '+name);
												$('#companyName').val(name);
												$('#Preferredlanguage').val(language);
												$('#nationality').val(nationality);
												$('#nationId').val(nationId);
												$('#agentb2cmail').val(email);
												$('#marketType').val(marketType);
												$('#marketId').val(marketId);

												$('#agentDivision').val(divisionId);
												$('#agentDesignation').val(designationName);

												$('#tourType').val(tourType);
												$('#agentb2cnumber').val(phone);
												$('#contactPName').val(contactPName);
												$('#companyId').val(id);
												$('#salesassignTo').val(salesPerson);
												if(opsPerson!=''){
													$('#opsPersonName').val(opsPerson);
													$('#opsPersonId').val(opsPersonId);
												}else {
													$('#opsPersonName').val('');
													$('#opsPersonId').val('');
												}
												$('#getDocketCompanyName').hide();
											}
										</script>
										<input name="companyId" type="hidden" id="companyId" value="<?php echo encode($editcompanyId); ?>" />
										<input name="addnewcontactmain" type="hidden" id="addnewcontactmain" value="0" />
									</label>
								</div>
							</td>
							<td width="10%">
							</td>
							<td width="35%">
								
							</td>
						</tr>
					</table>
					<!-- agentb2cname -->
					<table width="100%" border="0" cellspacing="0" cellpadding="0" id="banumber" style="display:<?php if($clientType!=''){ ?>block<?php } else { ?>none<?php } ?>; "> 
						<tr>
							<td width="20%"><div class="griddiv"><label>
								<div class="gridlable" >Division <span class="redmind"></span></div>
								<select id="agentDivision" name="agentDivision" class="gridfield validate" displayname="Division" autocomplete="off"  >
									<option value="">Select</option>
								 	<?php  
									$selectd='*';    
									$whered=' deletestatus=0 and status=1 order by name asc';  
									$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
									while($resListingd=mysqli_fetch_array($rsd)){  
									?>
									<option value="<?php echo strip($resListingd['id']); ?>" <?php if($resListingd['id']==$editagentDivision){ ?>selected="selected"<?php } ?>><?php echo strip($resListingd['name']); ?></option>
									<?php } ?>
								</select>
								</label>
								</div>
							</td>
							<td width="20%">
								<div class="griddiv" ><label>
								<div class="gridlable" >Designation</div>
								<input name="agentDesignation" type="text" class="gridfield" id="agentDesignation" displayname="Designation" value="<?php echo $editagentDesignation; ?>" />
									</label>
								</div>
							</td>
							<td width="20%"><div class="griddiv"><label>
								<div class="gridlable" >
									<c id="contactpersonnamespan">Contact Person </c>
									<span class="redmind"></span>
								</div>
								<input name="contactPName" type="text" class="gridfield validate" id="contactPName"  displayname="Contact Person"   value="<?php echo $clientnemdisplay; ?>" />
								</label>
								</div>
							</td>
							<td width="20%"><div class="griddiv" ><label>
								<div class="gridlable" >Phone/Mobile <span class="redmind"></span></div>
								<input name="agentb2cnumber" type="text" class="gridfield validate" id="agentb2cnumber"  displayname="Phone/Mobile"   value="<?php echo $getphone; ?>" />
								</label>
								</div>
							</td>
							
							<td >
								<div class="griddiv" id="baemail" ><label>
									<div class="gridlable" >Email<span class="redmind"></span></div>
									<input name="agentb2cmail" type="email" class="gridfield validate" id="agentb2cmail"  displayname="Email"    value="<?php echo $getemail; ?>" required />
								</label>
							</div>
							</td>
						</tr>
						<!-- <tr>
							<td width="50%">
							<div class="griddiv"><label>
							<div class="gridlable" ><c>Market Type </c></div>
							<input name="marketType" type="text" class="gridfield" id="marketType" readonly displayname="Market Type" value="<?php echo $marketType ?>" />
							<input name="marketId" type="hidden" id="marketId" value="<?php echo $marketId; ?>" />
							</label>
							</div>
							</td>
							<td width="50%"><div class="griddiv" ><label>
							<div class="gridlable" >Nationality</div>
							<input name="nationality" type="text" class="gridfield" id="nationality" readonly displayname="Nationality"  value="<?php echo $nationality; ?>" />
							<input name="nationId" type="hidden" id="nationId" value="<?php echo $nationId; ?>" />
							</label>
							</div></td>
						</tr> -->
					</table>
				</div>
			</td>
			<td align="left" valign="top" >
				<!-- <div style="background-color:#f5f5f5; padding:10px;  cursor:pointer;">Other Information</div> -->
				<div style=" padding:10px;border:1px #ccc solid; display:block; " >
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="50%">
								<!-- lead pax and subject -->
								<div class="griddiv" ><label>
									<div class="gridlable">Lead&nbsp;Pax&nbsp;Name</div>
									<input name="leadPaxName" type="text" class="gridfield"  id="leadPaxName"  value="<?php echo $editleadPaxName; ?>" maxlength="100" />
									</label>
								</div>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<!--AssignTO -->
						<tr>
							<td width="50%">
								<div class="griddiv" style="width: 100%;"><img src="images/userrole.png" onclick="function_assignTo();" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;"  />
									<label>
									<div class="gridlable" style="width:100%;">Operation Person<span class="redmind"></span></div>
									<div id="selectOpsPerson">
										<input name="opsPersonName" type="text" class="gridfield  validate" id="opsPersonName" value="<?php echo getUserName($editopsPersonId); ?>" readonly="true" displayname="Operation&nbsp;Person" autocomplete="off" onclick="function_assignTo();" />
										<input name="opsPersonId" type="hidden" id="opsPersonId" value="<?php echo encode($editopsPersonId); ?>" /></div>
									</label>
									<script type="text/javascript">
										function function_assignTo(){
											var lang = $('#language').val();
											alertspopupopen('action=selectDocketParent&userType=1','600px','auto');
										}
									</script>
								</div>
							</td>
							<td width="50%">
								<div class="griddiv " style="width: 100%;">
									<label>
										<div class="gridlable" style="width:100%;">Sales Person<span class="redmind"></span></div>
										<div id="selectOpsPerson">
											<input type="text" name="salesassignTo" id="salesassignTo" class="gridfield" value="<?php echo $editresult['salesassignTo']; ?>" readonly="" />
										</div>
									</label>
								</div>
							</td>
						</tr>
					</table>
					<!-- pax details -->
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style=" ">
						<tr>
							<td width="20%" align="left" valign="top">
								<div class="griddiv " style="width: 100%;">
								<label >
									<div class="gridlable">Adult<span class="redmind"></span></div>
									<input name="adult" type="text" class="gridfield validate" onKeyUp="numericFilter(this);" id="adult" displayname="Adult" value="<?php echo $editresult['adult']; ?>" maxlength="3"   />
								</label>
								</div>
							</td>
							<td width="20%" align="left" valign="top">
								<div class="griddiv " style="width: 100%;">
								<label style=" position: relative; ">
									<div class="gridlable">Child</div>
									<input name="child" type="text" class="gridfield" id="child" onKeyUp="numericFilter(this);showcwbroom();" displayname="Child" value="<?php echo $editresult['child']; ?>" maxlength="3" /> 
								</label>
								</div>
							</td>
					
							<td width="20%" align="left" valign="top">
								<div class="griddiv " style="width: 100%;">
								<label >
									<div class="gridlable">SGL Room </div>
									<input name="sglRoom" type="text" class="gridfield " id="sglRoom"  value="<?php echo $editresult['sglRoom']; ?>"  />
								</label>
								</div>
							</td>
							<td width="20%" align="left" valign="top">
								<div class="griddiv " style="width: 100%;">
								<label >
									<div class="gridlable">DBL Room </div>
									<input name="dblRoom" type="text" class="gridfield " id="dblRoom"  value="<?php echo $editresult['dblRoom']; ?>"  />
								</label>
								</div>
							</td>
							<td width="20%" align="left" valign="top">
								<div class="griddiv " style="width: 100%;">
								<label >
									<div class="gridlable">TPL Room </div>
									<input name="tplRoom" type="text" class="gridfield " id="tplRoom"  value="<?php echo $editresult['tplRoom']; ?>"  />
								</label>
								</div>
							</td>
							<td width="20%" align="left" valign="top">
								<div class="griddiv " style="width: 100%;">
								<label >
									<div class="gridlable">E.Bed(Adult) </div>
									<input name="extraBedA" type="text" class="gridfield " id="extraBedA"  value="<?php echo $editresult['extraBedA']; ?>"  />
								</label>
								</div>
							</td>
							<td width="20%" align="left" valign="top">
								<div class="griddiv " style="width: 100%;">
								<label >
									<div class="gridlable">E.Bed(Child) </div>
									<input name="extraBedC" type="text" class="gridfield " id="extraBedC"  value="<?php echo $editresult['extraBedC']; ?>"  />
								</label>
								</div>
							</td>
						</tr>
					</table>
					<!-- age block -->
					<table width="100%" border="0" cellpadding="4" cellspacing="0"  id="childfielddiv" style="display:none; ">
						<tr>
							<script>
								function showcwbroom(){
									var child = $('#child').val();
									if(child == 0 || child == ''){
									$('.showcwbroom').css("display","none");
									}else{
										$('.showcwbroom').css("display","block");
									}
								}
								showcwbroom();

								var childnumber=1;
								function appendchildage(no){
									$('.childagedivchilds').html('');
									var child=$('#child').val();
									if(child>0){
										$('#childfielddiv').show();
									}else{
										$('#childfielddiv').hide();
									}
									for(c=1;c<=child; c++){
										$('#childagediv').append('<div style="float:left; margin-right:5px;margin-bottom:8px; width:24%;"><label><div class="gridlable" style="width:100%;">Child '+c+' Age</div><input name="childrensage[]" type="text" class="gridfield childage" id="childrensage'+c+'"  displayname="Child1 Age"  onKeyUp="numericFilter(this);calculateage('+c+');"  maxlength="2" value="<?php echo $age1; ?>" placeholder="Max Age 12 Years"/></label></div>');
									}
									childnumber++;
								}

								function calculateage(id){
									var childrensage = $('#childrensage'+id).val();
									if(childrensage>12){
										alert('Child age should not be greater than 12 years');
										$('#childrensage'+id).val('');
									}
								}
							</script>
							<td style="padding-left:0px;" id="childagediv" class="childagedivchilds">	</td>
						</tr>
					</table>
				</div>
			</td> 
		</tr>
		<tr >
			<td colspan="2" align="left" valign="top" style="padding-top:20px;">
				<div style="background-color:#f5f5f5; padding:10px; border:1px #ccc solid; cursor:pointer;" >SERVICES</div>
				<?php if($_REQUEST['id']!=''){ ?>
				<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; " >
					<table id="serviceSearchBox " class="servicetable" border="1"  >
						<thead>
							<tr>
								<td align="left"  width="8%">City</td>
								<td align="left" width="8%">ServiceType</td>
								<td align="left" width="25%">Service Name</td>
								<td align="left" width="10%" class="hotelFilter">Room Type</td>
								<td align="left" width="10%" class="hotelFilter">Meal Plan</td>
								<td align="left" width="5%">From Date</td>
								<td align="left" width="5%">To Date</td>
								<td align="right" width="6%"></td>
								<td align="right" width="5%"></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<select class="selectBoxDest" id="searchCityId" onchange="loadServices(this.value,'hotel')">
										<option value="">Select City</option>
										<?php 
										$rs=GetPageRecord('*',_DESTINATION_MASTER_,' deletestatus=0 and status=1 order by name asc'); 
										while($resListing=mysqli_fetch_array($rs)){  
										?><option value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['name']); ?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<select id="searchsType" onchange="loadServices('',this.value)">
										<option value="">Service Type</option>
										<option value="hotel">Hotel</option>
										<option value="activity">Activity</option>
										<option value="entrance">Entrance</option>
										<!-- <option value="enroute">Enroute</option> -->
										<!-- <option value="transfer">Transfer</option> -->
										<option value="transportation">Transportation</option>
										<!-- <option value="guide">Guide</option> -->
										<option value="restaurant">Restaurant</option>
										<!-- <option value="additional">Additional</option> -->
									</select>
								</td>
								<td>
									<div id="searchServiceListBox">
										
									</div>
								</td>
								<td class="hotelFilter">
									<select  class="selectBoxDest" id="searchRoomTypeId">
										<option value="">Select Room</option>
										<?php 
										$rs2=GetPageRecord('*',_ROOM_TYPE_MASTER_,' name!="" and deletestatus=0 and status=1 order by name asc'); 
										while($resListing=mysqli_fetch_array($rs2)){  
										?><option value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['name']); ?></option>
										<?php } ?>
									</select>
								</td>
								<td class="hotelFilter">
									<select class="selectBoxDest" id="searchMealPlanId">
										<option value="">Select Meal</option>
										<?php 
										$rs2=GetPageRecord('*',_MEAL_PLAN_MASTER_,' name!="" and deletestatus=0 and status=1 order by name asc'); 
										while($resListing=mysqli_fetch_array($rs2)){  
										?><option value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['name']); ?></option>
										<?php } ?>
									</select>
								</td>
								<td><input type="date" id="searchcheckIn" value="<?php echo date('Y-m-d'); ?>" ></td>
								<td><input type="date" id="searchcheckOut" value="<?php echo date("Y-m-d", strtotime("+1 days")); ?>" ></td>
								<td align="right"><input type="button" value="Search" class=" searchbtnmain" onclick="loadSearchServicesRates();"></td>
								<td align="right">
								<button type="button" class="bluembutton" onclick="AddNewServicesRates();" style="padding:5px 10px!important;width: 100px;">
									<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add&nbsp;New
								</button>
								</td>
							</tr>
							<tr>
								<td colspan="8">&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<div id="loadserviceSearchBox">
						<!-- loaded search result here -->
					</div> 
					
				</div>
				<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; " id="servicesBox">
					
				</div>
				<?php }else{  ?>
				<div style=" border:1px #ccc solid; padding:10px;border-top:0px;display:block; " >
					Save Query First
				</div>
				<?php } ?>
			</td>
		</tr>
	</table>
 

</div>
</form>
</div>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<link rel="stylesheet" href="css/selectize.css"> 
<script type="text/javascript" src="js/selectize.js"></script>
<script type="text/javascript">
	function loadServices(cityId,sType){
		if(cityId>0){
			$('#searchsType').val('hotel');
		}else{
			var cityId = $('#searchCityId').val();
		}
		$('#searchServiceListBox').load('docket_loadalertbox.php?action=loadServices&sType='+sType+'&cityId='+cityId+'');
		if(sType=='hotel'){
			$('.hotelFilter').show();
		}else{
			$('.hotelFilter').hide();
		}
	}
	loadServices('','hotel');
	function loadSearchServicesRates() {
		var cityId= $('#searchCityId').val();
		var sType = $('#searchsType').val();
		var serviceId = $('#searchServiceId').val();
		var roomTypeId = $('#searchRoomTypeId').val();
		var mealPlanId = $('#searchMealPlanId').val();
		var checkIn = $('#searchcheckIn').val();
		var checkOut = $('#searchcheckOut').val();
		if(sType!='' && cityId!='' ){
			$('#loadserviceSearchBox').load("docket_loadalertbox.php?action=loadSearchServicesRates&queryId=<?php echo $lastQueryId; ?>&cityId="+cityId+"&sType="+sType+"&serviceId="+serviceId+"&roomTypeId="+roomTypeId+"&mealPlanId="+mealPlanId+"&checkIn="+checkIn+"&checkOut="+checkOut);
		}else{
			alert('Please select city and service type');
		}
	}		
	function AddNewServicesRates(){
		var cityId= $('#searchCityId').val();
		var checkIn = $('#searchcheckIn').val();
		var checkOut = $('#searchcheckOut').val();
		var sType = $('#searchsType').val();
		if(sType!='' && cityId!=''){
			docket_alertbox('action=loadAddNewServiceRate&queryId=<?php echo $lastQueryId; ?>&checkIn='+checkIn+'&checkOut='+checkOut+'&cityId='+cityId+'&sType='+sType,'900px','auto');
		}else{
			alert('Please select city and service type');
		}
	}
	function loadDocketServices(){
		$('#servicesBox').load("loadDocketServices.php?queryId=<?php echo $lastQueryId; ?>");
	}
	loadDocketServices();
</script>
<script type="text/javascript">
	// selectize
	$('.selectBoxDest').selectize();
	// numeric
	$(document).on("input", ".numeric", function() {
	this.value = this.value.replace(/\D/g,'');
	});
</script>
<style type="text/css">
.hotelFilter{
	display: none;
}
.addeditpagebox{
	padding:20px!important;
}
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
	width: 100% !important;
}
.servicetable td, .servicetable th , .servicetable thead td {
    padding: 3px;
}
.servicetable th,.servicetable thead td {
	background-color: #7a96ff;
    color: #fff;
    font-weight: 600;
}
table.servicetable {
    font-size: 14px;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    border-spacing: 0;
    border-color: #ccc;
    width: 100%;
}
table.servicetable select{
	width: 100%;
	font-size: 14px;
	border: 1px #e0e0e0 solid;
	box-sizing: border-box;
	padding: 5px;
}
table.servicetable .selectize-input {
	padding: 3px!important;
}
table.servicetable input.searchbtnmain{
	padding:5px 10px 5px 30px;
    font-size: 14px;
}
table.servicetable button.whitembutton{
	padding:5px 10px;
	background-color: #45b558;
	color: #fff;
}
.servicetable .editbtnselect, .servicetable .addBtn{
    padding: 2px 7px;
    text-align: center;
    font-size: 14px;
    border-radius: 0px;
    background-color: #4caf50;
    cursor: pointer;
    color: #fff;
}
.showBreakupCostDiv{
	display: none;
	background-color: #233a49;
    color: #000;
}
.showBreakupCostDiv table{
	background-color: white;
}

.showBreakupCostDiv table input{
	background-color: white;
	width: 90px;
}
.showBreakupCostDiv table select{
	background-color: white;
	width: 120px;
	margin-top: 4px
}
.dltBtn{
	float: right;
	color: #ff0000!important;
	    padding: 2px 9px
}

</style>