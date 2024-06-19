<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}

if($_GET['id']==''){ 
$where=' name="" and  addedBy='.$_SESSION['userid'].''; 
deleteRecord(_CORPORATE_MASTER_,$where);

$dateAdded= date('Y-m-d');
$namevalue ='name="",addedBy='.$_SESSION['userid'].',dateAdded="'.$dateAdded.'"'; 
$lastId = addlistinggetlastid(_CORPORATE_MASTER_,$namevalue); 
}


if($_GET['id']!=''){
	$id=clean(decode($_GET['id']));
	$paymentTerm=1;
	$select1='*';  
	$where1='id='.$id.''; 
	$rs1=GetPageRecord($select1,_CORPORATE_MASTER_,$where1); 
	$editresult=mysqli_fetch_array($rs1);

	$editassignTo=clean($editresult['assignTo']); 
	$editname=clean($editresult['name']); 

	$edittrnnumber=clean($editresult['PANNumber']); 
	$editpannumber=clean($editresult['TRNNumber']);
	 
	$editcontactPerson=clean($editresult['contactPerson']);
	$editcompanyTypeId=clean($editresult['companyTypeId']);
	$editcountryId=clean($editresult['countryId']);
	$editstateId=clean($editresult['stateId']); 
	$editcityId=clean($editresult['cityId']); 
	$edittitle=clean($editresult['title']); 
	$addedBy=clean($editresult['addedBy']);
	$dateAdded=clean($editresult['dateAdded']);
	$modifyBy=clean($editresult['modifyBy']);
	$modifyDate=clean($editresult['modifyDate']);

	$editaddress1=clean($editresult['address1']);  
	$editaddress2=clean($editresult['address2']);  
	$editaddress3=clean($editresult['address3']);  
	$editpinCode=clean($editresult['pinCode']);
	$editgstn=clean($editresult['gstn']);
	$editagreement=clean($editresult['agreement']);
	$editcompanyCategory=clean($editresult['companyCategory']);
	$lastId=$editresult['id'];
	$paymentTerm=$editresult['paymentTerm'];
	$bussinessType=clean($editresult['bussinessType']);
	$editOpsAassignTo=clean($editresult['OpsAssignTo']);
	$destinationId=clean($editresult['destinationId']);
	$creditlimit=clean($editresult['creditlimit']);
	$creditdays=clean($editresult['creditdays']);
	$nationality=clean($editresult['nationality']);
	$tourType=clean($editresult['tourType']);
	$editcompanyLogo=clean($editresult['companyLogo']);
	$editmarketType=clean($editresult['marketType']);
	$editlanguage=clean($editresult['language']);
	$editcosortiaId=clean($editresult['cosortiaId']);
	$editISOId=clean($editresult['ISOId']);
}

?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editcorporate" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Company Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%"><div class="griddiv">
	<label>
	<div class="gridlable">Bussiness Type  <span class="redmind"></span></div>
	<select id="bussinessType" name="bussinessType" class="gridfield validate" displayname="Bussiness Type" autocomplete="off" onchange="getformFormat();"  >
		 <option value="">Select</option> 
		<?php  
		$rs='';   
		$rs=GetPageRecord('*','businessTypeMaster',' id != 2 and deletestatus=0 and status=1 order by name asc'); 
		while($resListing1=mysqli_fetch_array($rs)){  
		
		?>
		<option value="<?php echo strip($resListing1['id']); ?>" <?php if($resListing1['id']==$bussinessType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing1['name']); ?></option>
		<?php } ?> 
	</select>
	</label>
	</div></td>
    <td width="1%">&nbsp;</td>
    <td width="33%"><div class="griddiv"><label>
	<div class="gridlable">Company&nbsp;Logo</div>
	 <input name="companyLogo" type="file" class="gridfield" id="companyLogo" /> </label>
	</div></td>
    <td width="16%" align="center"><?php if($editcompanyLogo!=''){ ?><a href="agentLogo/<?php echo $editcompanyLogo; ?>" target="_blank" style="border: 1px solid; padding: 5px 20px; border-radius: 3px; background-color: #4CAF50; color: #fff !important; cursor: pointer;">View Logo</a> <?php } ?>
	   <input name="oldLogo" type="hidden" value="<?php echo $editcompanyLogo; ?>" id="oldLogo" /></td>
  </tr>
</table>

	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Company Type  <span class="redmind"></span></div>
	<select id="companyTypeId" name="companyTypeId" class="gridfield validate" displayname="Company Type" autocomplete="off" >
	<option value="">None</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by id asc';  
$rs=GetPageRecord($select,_COMPANY_TYPE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcompanyTypeId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Company Name<span class="redmind"></span>  </div>
	<input name="name" type="text" class="gridfield validate" id="name" value="<?php echo $editname; ?>" displayname="Company Name" maxlength="100" />
	</label>
	</div>



	<!-- CINNo and TRN No sec -->
	<div class="TRN_PANNo_SEC" style="display: flex;width:100%">
		<div class="griddiv" style="width:50%;margin-right: 10px;"><label>
			<div class="gridlable">PAN No.<span class=""></span>  </div>
			<input name="PANNumber" type="text" class="gridfield " id="PANNumber" value="<?php echo $editpannumber; ?>" displayname="PAN Number" maxlength="100" />
			</label>
		</div>

		<div class="griddiv" style="width:50%"><label>
			<div class="gridlable">TRN No.<span class=""></span>  </div>
			<input name="TRNNumber" type="text" class="gridfield " id="TRNNumber" value="<?php echo $edittrnnumber; ?>" displayname="TRN Number" maxlength="100" />
			</label>
		</div>
	</div>
	
	
	<div class="griddiv" style="display:none;"><label>
	<div class="gridlable">GSTN</div>
	<input name="gstn" type="text" class="gridfield" id="gstn" value="<?php echo $editgstn; ?>" maxlength="100"  style="text-transform:uppercase;" />
	</label>
	</div>
	
	
	<div id="languageAg" class="griddiv" style="border-bottom:0px;"> 
		<div>Agreement<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credit Limit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Credit Days--></div>
		<table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;" id="languageAg">
	<tr>
		<td style="padding:0px 0px;"><input name="agreement" type="radio"  style="display:block;"  onclick="$('#agreementattachmentDiv').show();$('#addeditfrm').append(''); "  value="1" <?php if($editagreement!=''){ ?>checked="checked"<?php }?>/>  </td>
		<td style="padding:0px 0px;">Yes</td>
		<td style="padding:0px 0px;">&nbsp;&nbsp;</td>
		<td style="padding:0px 0px;"><label><input name="agreement" type="radio" style="display:block;"  onclick="$('#agreementattachmentDiv').hide();" value="0"   <?php if($editagreement==''){ ?>checked="checked"<?php }?>/> 
		</label></td>
		<td>No</td> 

    
    <td><div class="griddiv" style="margin-left: 409px;">

			<label>

			<div class="gridlable">&nbsp;&nbsp;Preferred&nbsp;Language</div>

			<select id="language" name="language" class="gridfield" displayname="Preferred Language" autocomplete="off"   >
			   <?php
	$select='';

	$where='';

	$rs='';

	$select='*';

	$where=' deletestatus=0  order by name asc';

	$rs=GetPageRecord($select,'tbl_languagemaster',$where);

	while($resListing=mysqli_fetch_array($rs)){

	?>

	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']=='1'){ ?>selected="selected"<?php }else if($resListing['id']==$editlanguage && $resListing['status'] == 1){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>

	<?php } ?>

			</select>

			</label>

			</div></td>

    
    
    
  </tr>
</table>
	</div>
	
	<div class="griddiv" id="agreementattachmentDiv" <?php if($editagreement==''){ ?>style="display:none;"<?php } ?>><label>
	<div class="gridlable">Agreement Attachment<span class="redmind"></span></div>
	 <input name="agreementattachment" type="file" class="gridfield " id="agreementattachment" onchange="$('#agreementattachmentHid').val('1');"/>
	 <?php if($editagreement!=''){ ?>
	 <a href="download/<?php echo $editagreement; ?>" target="_blank"><div class="commattachedbox"><strong>Download Attachment</strong>
	   <input name="agreementattachment2"  class="" type="hidden" value="<?php echo $editagreement; ?>" id="agreementattachment2" />
	 </div>
	 </a>
	 <?php } ?>
	 <input name="agreementattachmentHid" type="hidden" class="" value="" id="agreementattachmentHid"  displayname="Agreement Attachment"  />
	</label>
	</div>
	
	<div class="griddiv"  style="display: inline-block;">
	<label>
	<div class="gridlable">status<span class="redmind"></span></div>
	<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off"   style="width: 100%;"> 	
	<option value="1" <?php if($editresult['status']=='1'){ ?>selected="selected"<?php } ?>>Active</option>
	<option value="0" <?php if($editresult['status']=='0'){ ?>selected="selected"<?php } ?>>In Active</option>
	</select></label>
    </div>
				<div id="defaultCommission" class="griddiv " style="display: none; width: 250px;">
						<label>
						<div class="gridlable w100" style="width: 115px;">Commission Name<span class="redmind"></span></div>
						<select name="commissionName"  id="commissionIdName" class="gridfield" value="<?php echo $editresult['commission']; ?>" displayname="Commission Name" onchange="getCommissionPercent();">
						<option value="0">Select Commision</option>	
						<?php 
						$cmrs = GetPageRecord('*','commissionMaster','name!=""');
						while($commssionData = mysqli_fetch_assoc($cmrs)){
							?>
							<option value="<?php echo $commssionData['id']; ?>" <?php if($editresult['commissionNameId']==$commssionData['id']){ ?> selected="selected" <?php } ?> ><?php echo $commssionData['name']; ?></option>
							<?php
						}
						
						?>
						
						</select>
						</label>
					</div>
				
				<div id="defaultCommissionslab" class="griddiv" style="display: none; width: 200px;">
						<label>
						<div class="gridlable w100" style="width: 115px;">Commission Slab<span class="redmind"></span></div>
						<input type="number" name="commission" class="gridfield" id="commissionper" value="<?php echo $editresult['commission']; ?>" maxlength="10" displayname="Commission"  readonly >
						</label>
					</div>
				
			<div id="loadcommissionPercent"></div>
			<script>
				function getCommissionPercent(){
					var commissionName = $("#commissionIdName").val();
					$("#loadcommissionPercent").load('searchaction.php?action=commissionPercentage&commissionNameId='+commissionName)
					
				}
			</script>

	  <!--==============================================================================================================================================================================-->
		</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> 
	<div id="rightBlock">
	<div class="griddiv" style="width:49%; display:inline-block;">

	<label>
	<div class="gridlable">Sales Person<span class="redmind"></span></div>

	<select id="assignTo" name="assignTo" class="gridfield"   autocomplete="off"  style="padding: 9px; height: 37px;"> 
	<option value="">Select</option>
      <?php   
		$select='*';    
		//  and id!=37 
		$where='superParentId='.$loginusersuperParentId.' and status="1" and deletestatus=0 and ( userType=0 or userType=2) order by firstName asc'; 
		$restypeSalesq=GetPageRecord($select,_USER_MASTER_,$where); 
		while($restypeSales=mysqli_fetch_array($restypeSalesq)){  
		?>
      <option value="<?php echo encode($restypeSales['id']); ?>" <?php if($restypeSales['id']==$editassignTo){ ?>selected="selected"<?php } ?>><?php echo strip($restypeSales['firstName']).' '.strip($restypeSales['lastName']); ?></option>
      <?php } ?>
    </select>
	
	
	</label>
	</div>
	
	
	<div class="griddiv" style="width:49%; display:inline-block;"> 
	<label>
	<div class="gridlable" style="width: 130px;">Operations Person </div>
	<div id="selectOpsPerson"> 
	<select id="OpsAssignTo" name="OpsAssignTo" class="gridfield"   autocomplete="off"  style="padding: 9px; height: 37px;"> 
	<option value="">Select</option>
      <?php  
		$select='*';    
		$where='( id=37 or admin=1 or superParentId='.$loginusersuperParentId.' ) and status="1" and deletestatus=0 and ( admin=1 or userType=1 or userType=2) order by firstName asc'; 
		$rs=GetPageRecord($select,_USER_MASTER_,$where); 
		while($restype=mysqli_fetch_array($rs)){  
		?>
      <option value="<?php echo strip($restype['id']); ?>" <?php if($restype['id']==$editOpsAassignTo){ ?>selected="selected"<?php } ?>><?php echo strip($restype['firstName']).' '.strip($restype['lastName']); ?></option>
      <?php } ?>
    </select>
	 </div>
	</label>
	</div>
				
			
	<div style="display:none;">
	<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Country  <span class="redmind"></span></div>
	<select id="countryId" name="countryId" class="gridfield" displayname="Country" autocomplete="off" onchange="selectstate();" >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcountryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">State </div>
	<select id="stateId" name="stateId" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();" >
</select></label>
	</div>
	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">City </div>
	<select id="cityId" name="cityId" class="gridfield" displayname="City" autocomplete="off" >
</select></label>
	</div>
	
	
	
	 
	<div class="griddiv"><label>
	<div class="gridlable">Address 1  </div>
	<input name="address1" type="text" class="gridfield" id="address1" value="<?php echo $editaddress1; ?>" maxlength="250" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Address 2  </div>
	<input name="address2" type="text" class="gridfield" id="address2" value="<?php echo $editaddress2; ?>" maxlength="250" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Address 3</div>
	<input name="address3" type="text" class="gridfield" id="address3" value="<?php echo $editaddress3; ?>" maxlength="250" />
	</label>
	</div>	
	
	<div class="griddiv"><label>
	<div class="gridlable">Pin Code </div>
	<input name="pinCode" type="text" class="gridfield" id="pinCode" value="<?php echo $editpinCode; ?>" maxlength="15" />
	</label>
	</div> 
	</div>
	<div style=" overflow:hidden;">
	<div style="margin-bottom:10px; font-size:13px; color:#8a8a8a; position:relative;">Address<strong style="position:absolute; right:0px;"><a onclick="alertspopupopen('action=addsupaddress&supid=<?php echo $lastId; ?>&addressType=corporate','700px','auto');">+ Add Address</a></strong></div>
	<div id="loadaddress"></div>
	<script>
	function loadaddress(dltid){
	$('#loadaddress').load('loadaddress.php?addressParent=<?php echo $lastId; ?>&addressType=corporate&dltid='+dltid);
	}
	loadaddress('0');
	</script>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="100"><div class="griddiv"> 
	<label> 
	<div class="gridlable">Market&nbsp;Type<span class="redmind"></span></div> 
	<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
  <?php   
$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by name asc');  
while($resListing=mysqli_fetch_array($rs)){   
?> 
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
<?php } ?>
</select></label>  
	</div></td>
	<td width="100"><div class="griddiv"> 
	<label> 
	<div class="gridlable">Nationality&nbsp;Type <span class="redmind"></span></div> 
	<select id="nationality" name="nationality" class="gridfield validate" displayname="Nationality Type" autocomplete="off" > 
	<?php   
	$rs=GetPageRecord('*','nationalityMaster',' deletestatus=0 and type=1 order by id asc');  
	while($resListing=mysqli_fetch_array($rs)){   
		?> 
	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$nationality){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); 	?></option> 
	<?php } ?>
	</select>
	</label>  
	</div>
	</td>	
    
  </tr>
  <tr>
		<td width="100"><div class="griddiv">
		<label>
		<div class="gridlable">Category <span class=""></span></div>
		<select id="companyCategory" name="companyCategory" class="gridfield " displayname="Category" autocomplete="off" >
		<option value="">Select</option>
		<option value="1" <?php if($editcompanyCategory==1){ ?>selected="selected"<?php } ?>>Big</option>
		<option value="2" <?php if($editcompanyCategory==2){ ?>selected="selected"<?php } ?>>Medium</option>
		<option value="3" <?php if($editcompanyCategory==3){ ?>selected="selected"<?php } ?>>Small</option>
		</select></label>
		</div></td>
	<td width="100"><div class="griddiv"> 
		<label> 
		<div class="gridlable">Tour&nbsp;Type<span class=""></span></div> 
		<select id="tourType" name="tourType" class="gridfield " displayname="Tour Type" autocomplete="off" > 
		<option value="">Select</option> 
	<?php   
	$rs=GetPageRecord($select,'tourTypeMaster',' deletestatus=0 order by name asc');  
	while($resListing=mysqli_fetch_array($rs)){   
	?> 
	<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$tourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
	<?php } ?>
	</select></label>  
		</div></td>	
  </tr>
</table>
 
	 
	<style>
	.select2-container{
	 width:100% !important;
	}
	</style>	 	
	
	</div> </td>

  </tr>
  <tr id="contactDetailId">
    <td colspan="2" align="left" valign="top" style="padding-right:20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <!-- <tr> -->
    <td width="65%"><div class="griddiv" style="border-bottom:0px;"> 
	<label>
	<div class="gridlable">Contact Person</div> 
	<div style="margin-top: 16px !important;">&nbsp;&nbsp;&nbsp;Division</div>
	<div id="loadcontactpers" style="margin-top: -11px;"><?php 
		$contactpCount=1;
		$select=''; 
		$where=''; 
		$rs='';  
		$select='*';    
		$where=' corporateId='.$lastId.' and contactPerson!="" and deletestatus=0 order by id asc';  
		$rs=GetPageRecord($select,'contactPersonMaster',$where); 
		while($resListing=mysqli_fetch_array($rs)){  
			?>
			<div id="phoneidcp<?php echo $contactpCount; ?>">
				<table width="100%" border="0" cellpadding="2" cellspacing="5">
				<tr>
				<td width="321" align="left">
				<select id="division<?php echo $contactpCount; ?>" name="division<?php echo $contactpCount; ?>" class="gridfield validate" displayname="Division" autocomplete="off"  placeholder="Division" >
				<option value="">Select</option>
				<?php  
				$selectd='*';    
				$whered=' deletestatus=0 and status=1 order by name asc';  
				$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
				while($resListingd=mysqli_fetch_array($rsd)){  
				?>
				<option value="<?php echo strip($resListingd['id']); ?>" <?php if($resListingd['id']==$resListing['division']){?> selected="selected"<?php } ?>><?php echo strip($resListingd['name']); ?></option>
				<?php } ?>
				</select>
		  	</td> 
	    	<td width="321" align="left">
	    		<input name="contactPerson<?php echo $contactpCount; ?>"  type="text" class="gridfield validate" id="contactPerson<?php echo $contactpCount; ?>" value="<?php echo $resListing['contactPerson']; ?>"  maxlength="100" placeholder="Contact Person" displayname="contactPerson" />
	    		<input name="contactPId<?php echo $contactpCount; ?>" type="hidden" value="<?php echo $resListing['id']; ?>" displayname="Contact Person"  />
				</td>
	    	<td width="288" align="left">
					<input name="designation<?php echo $contactpCount; ?>" type="text" class="gridfield validate" id="designation" value="<?php echo $resListing['designation']; ?>" placeholder="Designation" displayname="Designation" />
				</td>
	     
	    	<td width="144" align="center">
			<?php 
				$rsn="";
				$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
				$cmpcountryData=mysqli_fetch_array($rs1cmp);
				$compcountryCode = $cmpcountryData['compcountryCode'];
			?>


			<input name="countryCode<?php echo $contactpCount; ?>" type="text" class="gridfield validate" id="countryCode" value="<?php if($resListing['countryCode'] !=''){ echo $resListing['countryCode']; }else{ echo '+'. $compcountryCode;}  ?>" placeholder="Country Code" displayname="Country Code" />
		
		</td>
	 
	    	<td width="251" align="center"><input name="phone<?php echo $contactpCount; ?>" type="text" class="gridfield validate " id="phone" value="<?php echo decode($resListing['phone']); ?>" placeholder="Phone" displayname="Phone" maxlength="14" /></td>

	    	<td width="354" align="center"><input name="email<?php echo $contactpCount; ?>" type="text" class="gridfield validate" id="email" value="<?php echo decode($resListing['email']); ?>"  placeholder="Email" displayname="Email"/></td> 
	    	
	    	<td width="70" align="center">
					<?php if($contactpCount==1){ ?>
					<img src="images/addicon.png" width="20" height="20" onClick="addphoneNumberscp();" style="cursor:pointer;" />
					<?php } else { ?>
					<img src="images/deleteicon.png"  onclick="removecontactperson(<?php echo $contactpCount; ?>,<?php echo $resListing['id']; ?>);" style="cursor:pointer;" />
					<?php } ?>	
				</td>
				</tr>
				</table>   
			</div> 
			<?php $contactpCount++; 
		} ?>
  
	 	<?php 
 		if($contactpCount==1){ ?>
 		<div id="phoneidcp1">
 		<table width="100%" border="0" cellpadding="2" cellspacing="5">
			<tr>
				<td width="321" align="left">
				<select id="division1" name="division1" class="gridfield validate" displayname="Division" autocomplete="off"  placeholder="Division" >
				<option value="">Select</option>
					 <?php  
					$selectd='*';    
					$whered=' deletestatus=0 and status=1 order by name asc';  
					$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
					while($resListingd=mysqli_fetch_array($rsd)){  
					?>
					<option value="<?php echo strip($resListingd['id']); ?>"><?php echo strip($resListingd['name']); ?></option>
					<?php } ?>
				</select>
				</td>
		    <td width="321" align="left"><input name="contactPerson1" type="text" class="gridfield" id="contactPerson1" value="" displayname="Contact Person"  maxlength="100" placeholder="Contact Person" /></td> 
		    <td width="288" align="left"><input name="designation1" type="text" class="gridfield" id="designation1" value="" displayname="Designation" placeholder="Designation" /></td> 
		    <td width="144" align="center">
			<?php 
			$rsn="";
			$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
			$cmpcountryData=mysqli_fetch_array($rs1cmp);
			$compcountryCode = $cmpcountryData['compcountryCode'];
			?>
				<input name="countryCode1" type="text" class="gridfield" id="countryCode1" value="<?php echo '+'. $compcountryCode; ?>" displayname="Country Code" placeholder="+91" />
			
			</td> 
		    <td width="251" align="center"><input name="phone1" type="text" class="gridfield" id="phone1" value="" displayname="Phone"  placeholder="Phone" maxlength="14" /></td> 
		    <td width="354" align="center"><input name="email1" type="text" class="gridfield" id="email" value="" displayname="Email"  placeholder="Email" /></td> 
		    <td width="70" align="center"><input name="primaryvalue" class="gridfield" type="radio" value="1" checked="checked" style="display:block;"  ></td>
		    <td width="70" align="center"><img src="images/addicon.png" width="20" height="20" onClick="addphoneNumberscp();" style="cursor:pointer;" /></td>
		  </tr>
		</table> 
		</div>
		 <?php 
		} ?>
 		<input name="contactpCount" type="hidden" id="contactpCount" value="<?php if($contactpCount==1){ echo '1'; } else { echo $contactpCount; } ?>" />
 		<div id="deleteContactsDiv" style="display:none"></div>
	 <script>
	 function addphoneNumberscp(){
		var contactpCount = $('#contactpCount').val();
		contactpCount=Number(contactpCount)+1;  
		$.get("loadcontactperson.php?id="+contactpCount, function (data) { 
			$("#loadcontactpers").append(data); 
		}); 
		$('#contactpCount').val(contactpCount);
	 }
 
 
	 
	function removecontactperson(divId,contactId){
		if(confirm('Are you sure you want to delete this contact?')){
			$('#deleteContactsDiv').load('frmaction.php?action=deleteCorporateContacts&contactId='+contactId);
			$('#phoneidcp'+divId).remove();
			var contactpCount = $('#contactpCount').val();
			contactpCount=Number(contactpCount)-1;  
			$('#contactpCount').val(contactpCount);
		}
	}
	 </script>
 </div>
	 
	</label>
	
	</div></td>
    <td width="35%">&nbsp;</td>
  </tr>
</table>
</td>
    </tr>
</table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>
		<input type="hidden" name="type" id="typeId" value="" >	
		<input name="editId" type="hidden" id="editId" value="<?php echo encode($lastId); ?>" />
		<?php
		if($_GET['id']!=''){
		?>
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
		<?php } ?>
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td><input type="button" name="Submit" value="Save and New" class="whitembutton submitbtn"onclick="formValidation('addeditfrm','submitbtn','1');"/></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div>
<style>
	.commissonclass{
		display: inline-block;
	}
	.commissonclass2{
		display: none;
	}
</style>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
  $(document).ready(function() {
  $('.select2').select2();
   
  });
  </script>
<script>  
showedit();
comtabopenclose('linkbox','op2');
	
function getformFormat(){
		bussinessType = $("#bussinessType").val();

		if(bussinessType==21){
			
			$("#defaultCommission").show();
		
			$("#defaultCommissionslab").show();
			
			$("#defaultCommissionslab").removeClass("commissonclass2");
			$("#defaultCommission").removeClass("commissonclass2");

			$("#defaultCommissionslab").addClass("commissonclass");
			$("#defaultCommission").addClass("commissonclass");


			$("#commissionIdName").addClass("validate");
			$("#commissionper").addClass("validate");
			$("#languageAg").hide();
			// $("#nationalityic").hide();
			$("#rightBlock").hide();
			$("#contactDetailId").hide();
			// $("#tourTypeic").hide();
			// $("#languageic").hide();
			// $("#countryfield").hide();
			// $("#salesopRow").hide();
			// $("#isoandsonsortiarow").hide();
			
			// $("#localAgentic").hide();
			// $("#cmpdic").hide();
			
			// $("#cmpric").hide();
			$("#assignTo").removeClass("validate");
			$("#tourType").removeClass("validate");
			$("#commission").removeClass("validate");
			// $("#companyCategory").removeClass("validate");
			$("#division1").removeClass("validate");
			// $("#commission").addClass("validate");
			document.getElementById("typeId").value = "iso";
			
		}else if(bussinessType==22){

			$("#defaultCommission").show();
			$("#defaultCommissionslab").show();

			$("#commissionIdName").addClass("validate");
			$("#commissionper").addClass("validate");

			$("#defaultCommissionslab").addClass("commissonclass");
			$("#defaultCommission").addClass("commissonclass");

			$("#defaultCommissionslab").removeClass("commissonclass2");
			$("#defaultCommission").removeClass("commissonclass2");

			$("#languageAg").hide();
			$("#isoandsonsortiarow").hide();
			$("#rightBlock").hide();
			$("#contactDetailId").hide();
			// $("#salesopRow").hide();
			// $("#nationalityic").hide();
			// $("#companyCategoryic").hide();
			// $("#tourTypeic").hide();
			// $("#languageic").hide();
			// $("#countryfield").hide();
			// $("#localAgentic").hide()
			// $("#cmpdic").hide();
			// $("#cmpric").hide();
			$("#assignTo").removeClass("validate");
			$("#commission").removeClass("validate");
			$("#tourType").removeClass("validate");
			// $("#companyCategory").removeClass("validate");
			$("#division1").removeClass("validate");
			// $("#commission").addClass("validate");
			document.getElementById("typeId").value = "consortia";
		}else{
			$("#rightBlock").show();
			$("#languageAg").show();
			$("#contactDetailId").show();
			$("#isoandsonsortiarow").show();
			$("#compMarketrow").show();
			$("#salesopRow").show();
			$("#consortia").hide();
			$("#iso").hide();
			$("#defaultCommission").hide();
			$("#defaultCommissionslab").hide();
			$("#assignTo").addClass("validate");
			// $("#companyCategory").addClass("validate");
			$("#commissionper").removeClass("validate");
			$("#commissionIdName").removeClass("validate");
			$("#commission").removeClass("validate");
			$("#division1").addClass("validate");

			$("#defaultCommissionslab").removeClass("commissonclass");
			$("#defaultCommission").removeClass("commissonclass");

			$("#defaultCommissionslab").addClass("commissonclass2");
			$("#defaultCommission").addClass("commissonclass2");

		}

}
getformFormat();
</script>
