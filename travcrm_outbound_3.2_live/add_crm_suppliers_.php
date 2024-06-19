<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}
if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
if($_GET['id']==''){ 
/*$where=' name="" and  addedBy='.$_SESSION['userid'].''; 
deleteRecord(_SUPPLIERS_MASTER_,$where);*/
$dateAdded=time();
$namevalue ='name="",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.''; 
$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue); 
}
$paymentTerm=1;
if($_GET['id']!=''){
$id=clean(decode($_GET['id']));
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$editassignTo=clean($editresult['assignTo']); 
$editname=clean($editresult['name']); 
$editcontactPerson=clean($editresult['contactPerson']);
$supplierNumber=clean($editresult['supplierNumber']);
$editcompanyTypeId=clean($editresult['companyTypeId']);
$airlinesType=clean($editresult['airlinesType']);
$transferType=clean($editresult['transferType']);
$otherType=clean($editresult['otherType']);
$sightseeingType=clean($editresult['sightseeingType']); 
$entranceType=clean($editresult['entranceType']); // ENTRANCE ADDED TYPE 

$editcountryId=clean($editresult['countryId']);
$editstateId=clean($editresult['stateId']); 
$editcityId=clean($editresult['cityId']); 
$edittitle=clean($editresult['title']); 
$editcategoryId=clean($editresult['categoryId']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']);
$supplierMainType=clean($editresult['supplierMainType']); 
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$editpinCode=clean($editresult['pinCode']);
$editgstn=clean($editresult['gstn']);
$editagreement=clean($editresult['agreement']);
$locationMap=($editresult['locationMap']);
$editdestinationId=clean($editresult['destinationId']);
$lastId=$editresult['id'];
$paymentTerm=$editresult['paymentTerm'];
$image=$editresult['image'];
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
  <input name="action" type="hidden" id="action" value="editsuppliers" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Supplier Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><div class="griddiv"><label>
	<div class="gridlable" style="width:150px;">Supplier Number   </div>
	<input name="supplierNumber" type="text" class="gridfield" id="supplierNumber" value="<?php echo $supplierNumber; ?>" displayname="Supplier Name" maxlength="100" />
	</label>
	</div></td>
    <td width="80%" style="padding-left:10px;"><div class="griddiv"><label>
	<div class="gridlable">Supplier Name<span class="redmind"></span>  </div>
	<input name="name" type="text" class="gridfield validate" id="name" value="<?php echo $editname; ?>" displayname="Supplier Name" maxlength="100" />
	</label>
	</div></td>
  </tr>
</table>

	
	
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Supplier Type<span class="redmind"></span>  </div>
	<select id="supplierMainType" name="supplierMainType" class="gridfield validate" displayname="Supplier Type" autocomplete="off"  onchange="$('#suppservice input:checkbox').attr('checked',false);supplierTypechange();"   >
	 <option value="1" <?php if($supplierMainType==1){ ?> selected="selected"<?php } ?>>Hotel</option> 
	 <option value="2" <?php if($supplierMainType==2){ ?> selected="selected"<?php } ?>>FTO</option>  
</select>
	</label>
	
	<script>
	function showsingleormulti(obj){
		var supplierMainType = $('#supplierMainType').val(); 
 		if(supplierMainType==1){ 
			$('#dest').show();
			$('#locat').show();
			var id  = $(obj).attr('id');
			if(id=='companyTypeId'){  
				$('#airlinesType').attr('checked',false);   
				$('#sightseeingType').attr('checked',false); 
				$('#cruiseType').attr('checked',false); 
				$('#entranceType').attr('checked',false);
			}  
 			if(id=='airlinesType'){ 
				$('#companyTypeId').attr('checked',false);  
				$('#transferType').attr('checked',false);  
				$('#sightseeingType').attr('checked',false); 
				$('#cruiseType').attr('checked',false); 
				$('#entranceType').attr('checked',false);
			} 
 			if(id=='transferType'){   
				$('#airlinesType').attr('checked',false);  
				$('#sightseeingType').attr('checked',false);
				$('#cruiseType').attr('checked',false);  
				$('#entranceType').attr('checked',false);
			}     
			if(id=='sightseeingType'){ 
				$('#companyTypeId').attr('checked',false);  
				$('#airlinesType').attr('checked',false);  
				$('#transferType').attr('checked',false); 
				$('#cruiseType').attr('checked',false); 
				$('#entranceType').attr('checked',false);
			}   
			if(id=='entranceType'){ 
				$('#companyTypeId').attr('checked',false);  
				$('#airlinesType').attr('checked',false);  
				$('#transferType').attr('checked',false); 
				$('#cruiseType').attr('checked',false); 
				$('#sightseeingType').attr('checked',false);
			} 
			if(id=='cruiseType'){ 
				$('#companyTypeId').attr('checked',false);
				$('#entranceType').attr('checked',false);  
				$('#airlinesType').attr('checked',false);  
				$('#transferType').attr('checked',false); 
				$('#sightseeingType').attr('checked',false); 
			}  
 		}
 	}
	
	
	function supplierTypechange(){
		var supplierMainType = $('#supplierMainType').val();
		$('#dest').hide();
		$('#locat').hide();
		$('#hotelcategorydiv').hide();
	}
	</script>
	</div>
	<div class="griddiv">
	<div class="gridlable">Supplier Services  <span class="redmind"></span></div>
	<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;" id="suppservice" ><table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2"><label><input name="companyTypeId" type="checkbox" id="companyTypeId" style="display: block;" value="1"  <?php if($editcompanyTypeId==1){ ?>checked="checked" <?php } ?>  onchange="showsingleormulti(this);"/>
    </label></td>
    <td width="96%">Hotel</td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="airlinesType" type="checkbox" id="airlinesType" onchange="showsingleormulti(this);" style="display: block;" value="2"  <?php if($airlinesType==2){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td>Flight</td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="transferType" type="checkbox" id="transferType" onchange="showsingleormulti(this);" style="display: block;" value="10"  <?php if($transferType==10){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td>Transfer</td>
  </tr>  
  <tr style="display:none">
    <td colspan="2"><label><input name="sightseeingType" type="checkbox" id="sightseeingType" onchange="showsingleormulti(this);" style="display: block;" value="11" <?php if($sightseeingType==11){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td>Sightseeing</td>
  </tr>
  <tr>
    <td colspan="2"><label><input name="entranceType" type="checkbox" id="entranceType" onchange="showsingleormulti(this);" style="display: block;" value="14" <?php if($entranceType==11){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td>Entrance </td>
  </tr>
  <tr style="display:none">
    <td colspan="2"><label><input name="cruiseType" type="checkbox" id="cruiseType" onchange="showsingleormulti(this);" style="display: block;" value="12" <?php if($sightseeingType==12){ ?>checked="checked" <?php } ?>/>
    </label></td>
    <td>Cruise</td>
  </tr>
  <tr>
    <td colspan="2"><input name="otherType" type="checkbox" id="otherType" onchange="showsingleormulti(this);" style="display: block;" value="13" <?php if($otherType==13){ ?>checked="checked" <?php } ?>/></td>
    <td>Other</td>
  </tr>
  
</table>
</div>
	</div>
	
	
	 
	
	
	
	<div class="griddiv" style="display:none;"><label>
	<div class="gridlable">GSTN</div>
	<input name="gstn" type="text" class="gridfield" id="gstn"  style="text-transform:uppercase;" value="<?php echo $editgstn; ?>" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv" style="border-bottom:0px;"> 
	<div class="gridlable">Payment Term    </div>
	 <table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">
  <tr>
    <td style="padding:0px 0px;"><input name="paymentTerm" type="radio"  style="display:block;" value="1" <?php if($paymentTerm==1){ ?>checked="paymentTerm"<?php }?>/>  </td>
    <td style="padding:0px 0px;">Cash</td>
    <td style="padding:0px 0px;">&nbsp;&nbsp;</td>
    <td style="padding:0px 0px;"><label><input name="paymentTerm" type="radio" style="display:block;" value="2"   <?php if($paymentTerm==2){ ?>checked="paymentTerm"<?php }?>/> 
       </label></td>
    <td>Credit</td> 
  </tr>
</table>
 
	</div>
	<div class="griddiv" style="border-bottom:0px;"> 
	<div class="gridlable">Agreement   </div>
	 <table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">
  <tr>
    <td style="padding:0px 0px;"><input name="agreement" type="radio"  style="display:block;"  onclick="$('#agreementattachmentDiv').show();$('#addeditfrm').append(''); "  value="1" <?php if($editagreement!=''){ ?>checked="checked"<?php }?>/>  </td>
    <td style="padding:0px 0px;">Yes</td>
    <td style="padding:0px 0px;">&nbsp;&nbsp;</td>
    <td style="padding:0px 0px;"><label><input name="agreement" type="radio" style="display:block;"  onclick="$('#agreementattachmentDiv').hide();" value="0"   <?php if($editagreement==''){ ?>checked="checked"<?php }?>/> 
       </label></td>
    <td>No</td> 
  </tr>
</table>
 
	</div>
	
	<div class="griddiv" id="agreementattachmentDiv" <?php if($editagreement==''){ ?>style="display:none;"<?php } ?>><label>
	<div class="gridlable">Agreement Attachment<span class="redmind"></span></div>
	 <input name="agreementattachment" type="file" class="gridfield" id="agreementattachment" onchange="$('#agreementattachmentHid').val('1');"/>
	 <?php if($editagreement!=''){ ?>
	 <a href="download/<?php echo $editagreement; ?>" target="_blank"><div class="commattachedbox"><strong>Download Attachment</strong>
	   <input name="agreementattachment2" type="hidden" value="<?php echo $editagreement; ?>" id="agreementattachment2" />
	 </div>
	 </a>
	 <?php } ?>
	 <input name="agreementattachmentHid" type="hidden" class="" value="" id="agreementattachmentHid"  displayname="Agreement Attachment"  />
	</label>
	</div>
	<div class="griddiv" style="display:none;"><img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer; right:4px; top:26px;" onclick="alertspopupopen('action=selectParent','600px','auto');" />
	<label>
	<div class="gridlable">Assign To<span class="redmind"></span></div>
	<input name="ownerName" type="text" class="gridfield" id="ownerName" value="<?php echo getUserName($editassignTo); ?>" readonly="true" displayname="Assign To" autocomplete="off" onclick="alertspopupopen('action=selectParent','600px','auto');" />
	<input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editassignTo); ?>" />
	</label>
	</div>	 
	<div class="griddiv"><label>
	<div class="gridlable">Contact Person</div>
	<input name="contactPerson" type="text" class="gridfield" id="contactPerson" value="<?php echo $editcontactPerson; ?>"  maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv" style="border-bottom:0px;"> 
	<label>
	<div class="gridlable">Mobile / Landline / Fax </div>
	
	<div id="loadphonenumber"><?php 
$phonen=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' masterId='.$lastId.' and sectionType="suppliers" order by id asc';  
$rs=GetPageRecord($select,_PHONE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
 <div id="phoneid<?php echo $phonen; ?>">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" align="left">
	
	<select id="PhoneTypeId<?php echo $phonen; ?>" name="PhoneTypeId<?php echo $phonen; ?>" class="gridfield"  autocomplete="off" style="padding: 9px; height: 37px;">
	 
 <?php 
$select2='*';    
$where2=' status=1 order by id asc';  
$rs2=GetPageRecord($select2,_PHONE_TYPE_MASTER_,$where2); 
while($restype2=mysqli_fetch_array($rs2)){  
?>
<option value="<?php echo strip($restype2['id']); ?>" <?php if($restype2['id']==$resListing['phoneType']){ ?>selected="selected"<?php } ?>><?php echo strip($restype2['name']); ?></option>
<?php } ?>
</select></td>
    <td width="0%" align="left">&nbsp;&nbsp;</td>
    <td width="66%" align="left"><input name="PhoneNo<?php echo $phonen; ?>" type="number" class="gridfield validate" displayname="Mobile" id="PhoneNo<?php echo $phonen; ?>" value="<?php echo $resListing['phoneNo']; ?>" maxlength="14" /></td>
    <td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;">
 
      
      <lable><input name="primaryValue" type="radio" value="<?php echo $phonen; ?>"  style="display:block;" <?php if($resListing['primaryvalue']==1){ ?>checked="checked"<?php }?>/>
      </lable>
    </div></td>
    <td width="6%" align="center">
	<?php if($phonen==1){ ?>
	<img src="images/addicon.png" width="20" height="20" onclick="addphoneNumbers();" style="cursor:pointer;" />
	<?php } else { ?>
	<img src="images/deleteicon.png"  onclick="removephoneNumbers(<?php echo $phonen; ?>);" style="cursor:pointer;" />
	<?php } ?>	</td>
  </tr>
</table>
</div>
 
 <?php $phonen++; } ?>
 
 <?php if($phonen==1){ ?>
 <div id="phoneid1">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" align="left"><select id="PhoneTypeId1" name="PhoneTypeId1" class="gridfield"   autocomplete="off"  style="padding: 9px; height: 37px;">
      
      <?php 
$select='*';    
$where=' status=1 order by id asc';  
$rs=GetPageRecord($select,_PHONE_TYPE_MASTER_,$where); 
while($restype=mysqli_fetch_array($rs)){  
?>
      <option value="<?php echo strip($restype['id']); ?>" <?php if($restype['id']==$reslisting['phonetype']){ ?>selected="selected"<?php } ?>><?php echo strip($restype['name']); ?></option>
      <?php } ?>
    </select></td>
    <td width="0%" align="left">&nbsp;&nbsp;</td>
    <td width="66%" align="left"><input name="PhoneNo1" type="number" class="gridfield validate" displayname="Mobile" id="PhoneNo1" value="" maxlength="14" /></td>
    <td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;">
 
      
      <lable><input name="primaryValue" type="radio"  style="display:block;" value="1" checked="checked"  />
      </lable>
    </div></td>
    <td width="6%" align="center"><img src="images/addicon.png" width="20" height="20" onclick="addphoneNumbers();" style="cursor:pointer;" /></td>
  </tr>
</table>
</div>
 <?php } ?>
 <input name="phonecount" type="hidden" id="phonecount" value="<?php if($phonen==1){ echo '1'; } else { echo $phonen; } ?>" />
 <script>
 function addphoneNumbers(){
 var phonecount = $('#phonecount').val();
 phonecount=Number(phonecount)+1;  
 $.get("loadphonenumber.php?id="+phonecount, function (data) { 
$("#loadphonenumber").append(data); 
}); 
  $('#phonecount').val(phonecount);
 $
 }
 
 
 
 function removephoneNumbers(id){
 $('#phoneid'+id).remove();
 var phonecount = $('#phonecount').val();
 phonecount=Number(phonecount)-1;  
 $('#phonecount').val(phonecount);
 }
 </script>
 </div>
	 
	</label>
	
	</div> 
	
	
	<div class="griddiv" style="border-bottom:0px;"> 
	<label>
	<div class="gridlable">Email</div>
	
	<div id="loademail"><?php 
$phonen=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' masterId='.$lastId.' and sectionType="suppliers" order by id asc';  
$rs=GetPageRecord($select,_EMAIL_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
 <div id="emailid<?php echo $phonen; ?>">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" align="left">
	
	<select id="EmailTypeId<?php echo $phonen; ?>" name="EmailTypeId<?php echo $phonen; ?>" class="gridfield"  autocomplete="off" style="padding: 9px; height: 37px;">
	
 <?php 
$select2='*';    
$where2=' status=1 order by id asc';  
$rs2=GetPageRecord($select2,_EMAIL_TYPE_MASTER_,$where2); 
while($restype2=mysqli_fetch_array($rs2)){  
?>
<option value="<?php echo strip($restype2['id']); ?>" <?php if($restype2['id']==$resListing['emailType']){ ?>selected="selected"<?php } ?>><?php echo strip($restype2['name']); ?></option>
<?php } ?>
</select></td>
    <td width="0%" align="left">&nbsp;&nbsp;</td>
    <td width="66%" align="left"><input name="Email<?php echo $phonen; ?>" type="email" class="gridfield validate"  displayname="Email" id="Email<?php echo $phonen; ?>" value="<?php echo $resListing['email']; ?>" maxlength="100" /></td>
    <td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;">
 
      
      <lable><input name="emailprimaryValue" type="radio" value="<?php echo $phonen; ?>"  style="display:block;" <?php if($resListing['primaryvalue']==1){ ?>checked="checked"<?php }?>/>
      </lable>
    </div></td>
    <td width="6%" align="center">
	<?php if($phonen==1){ ?>
	<img src="images/addicon.png" width="20" height="20" onclick="addEmail();" style="cursor:pointer;" />
	<?php } else { ?>
	<img src="images/deleteicon.png"  onclick="removeEmail(<?php echo $phonen; ?>);" style="cursor:pointer;" />
	<?php } ?>	</td>
  </tr>
</table>
</div>
 
 <?php $phonen++; } ?>
 
 <?php if($phonen==1){ ?>
 <div id="emailid1">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" align="left"><select id="EmailTypeId1" name="EmailTypeId1" class="gridfield"   autocomplete="off"  style="padding: 9px; height: 37px;">
     
      <?php 
$select='*';    
$where=' status=1 order by id asc';  
$rs=GetPageRecord($select,_EMAIL_TYPE_MASTER_,$where); 
while($restype=mysqli_fetch_array($rs)){  
?>
      <option value="<?php echo strip($restype['id']); ?>" <?php if($restype['id']==$reslisting['emailtype']){ ?>selected="selected"<?php } ?>><?php echo strip($restype['name']); ?></option>
      <?php } ?>
    </select></td>
    <td width="0%" align="left">&nbsp;&nbsp;</td>
    <td width="66%" align="left"><input name="Email1" type="email" class="gridfield validate" id="Email1" displayname="Email" value="" maxlength="100" /></td>
    <td width="3%" align="center"><div style="padding:3px 6px; font-size:12px; color:#009900;">
 
      
      <lable><input name="emailprimaryValue" type="radio"  style="display:block;" value="1" checked="checked"  />
      </lable>
    </div></td>
    <td width="6%" align="center"><img src="images/addicon.png" width="20" height="20" onclick="addEmail();" style="cursor:pointer;" /></td>
  </tr>
</table>
</div>
 <?php } ?>
 <input name="emailcount" type="hidden" id="emailcount" value="<?php if($phonen==1){ echo '1'; } else { echo $phonen; } ?>" />
 <script>
 function addEmail(){
 var phonecount = $('#emailcount').val();
 phonecount=Number(phonecount)+1;  
 $.get("loademail.php?id="+phonecount, function (data) { 
$("#loademail").append(data); 
}); 
  $('#emailcount').val(phonecount);
 $
 }
 
 
 
 function removeEmail(id){
 $('#emailid'+id).remove();
 var phonecount = $('#emailcount').val();
 phonecount=Number(phonecount)-1;  
 $('#emailcount').val(phonecount);
 }
 
 function hotelcategorydivshowhide(){
 var companyTypeId  = $('#companyTypeId').val();
 if(companyTypeId==1){
 $('#hotelcategorydiv').show();
 } else {
 $('#hotelcategorydiv').hide();
 } 
 
 }
 </script>
 </div>
	 
	</label>
	
	</div> 		
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	<!--<div class="griddiv" id="hotelcategorydiv" style="display:none;<?php if($editcompanyTypeId==1){ ?> display:block;<?php } ?>">
	<label>
	
	<script>
	function selectOpsPersonfunction(){
	var destinationId = $('#destinationId').val();
	if(destinationId>0){
	$('#selectOpsPerson').load('selectOpsPerson.php?id='+destinationId);
	}
	} 
	</script>
	
	<div class="gridlable">Hotel Category  </div>
	<select id="categoryId" name="categoryId" class="gridfield" displayname="Hotel Category" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_HOTEL_CATEGORY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcategoryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div>-->  
	
	
	
	
	
	
	 
	
	
	 <div class="griddiv">
	<label id="dest">
	
	
	
	<div class="gridlable" >Destination  </div>
	<select id="destinationId" name="destinationId" class="gridfield " displayname="Destination" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editdestinationId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
	</div> 
	
	<div style=" overflow:hidden;">
	<div style="margin-bottom:10px; font-size:13px; color:#8a8a8a; position:relative;">Address<strong style="position:absolute; right:0px;"><a onclick="alertspopupopen('action=addsupaddress&supid=<?php echo $lastId; ?>','700px','auto');">+ Add Address</a></strong></div>
	<div id="loadaddress"></div>
	
	</div>
	<script>
	function loadaddress(dltid){
	$('#loadaddress').load('loadaddress.php?addressParent=<?php echo $lastId; ?>&addressType=supplier&dltid='+dltid);
	}
	loadaddress('0');
	</script>
	<div style="display:none;">
		<div class="griddiv">
	<label>
	
	
	
	<div class="gridlable">Country  </div>
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
	<div class="gridlable">City  </div>
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
	<div class="griddiv" id="locat"><label>
	<div class="gridlable">Location (MAP) </div>
	<input name="locationMap" type="text" class="gridfield" id="locationMap" value="<?php echo $locationMap; ?>" maxlength="500" />
	</label>
	</div>
	 
	<div class="griddiv"><label><?php if($image==''){
			echo '';
	}else{?>
		<?php echo '<img src="profilepic/<?php echo $image;?>">'; ?>
		<?php }?>
	<div class="gridlable">Upload Image</div>
	<input name="image" type="file" class="gridfield" id="image" accept="image/x-png,image/gif,image/jpeg"/>
	</label>
	</div>
	 	 </td>
  </tr>
</table>
</div>
<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="<?php echo encode($lastId); ?>" />
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
<script>  
comtabopenclose('linkbox','op2');
</script>

