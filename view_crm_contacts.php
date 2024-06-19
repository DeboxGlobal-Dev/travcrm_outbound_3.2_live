<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CONTACT_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$tourType=clean($editresult['tourType']); 
$nationality=clean($editresult['nationality']); 
$editcontacttitleId=clean($editresult['contacttitleId']); 
$editfirstName=clean($editresult['firstName']);
$editlastName=clean($editresult['lastName']);
$editdesignationId=clean($editresult['designationId']);
$editbirthDate=clean($editresult['birthDate']);
$editanniversaryDate=clean($editresult['anniversaryDate']);
$editcompanyTypeId=clean($editresult['companyTypeId']);
$editcountryId=clean($editresult['countryId']);
$editstateId=clean($editresult['stateId']); 
$editcityId=clean($editresult['cityId']); 
$edittitle=clean($editresult['title']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']);
$editsupId=clean($editresult['id']);
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$addressInfo=clean($editresult['addressInfo']);  
$editremark1=clean($editresult['remark1']);  
$editremark2=clean($editresult['remark2']);  
$editremark3=clean($editresult['remark3']);  
$editpinCode=clean($editresult['pinCode']);
$editfacebook=clean($editresult['facebook']);
$edittwitter=clean($editresult['twitter']);
$editlinkedIn=clean($editresult['linkedIn']);
}


if($editassignTo!=''){ 

$select1='firstName,lastName,id';  
$where1='id='.$editassignTo.''; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editOwnerresult=mysqli_fetch_array($rs1);

$assignfullName=strip($editOwnerresult['firstName'].' '.$editOwnerresult['lastName']); 
$assignfullId=encode($editOwnerresult['id']); 

}  
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
	  <?php if($_REQUEST['guestList']==3){?> 
		<td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancelGuest('<?php echo $_REQUEST['guestList'] ?>','<?php echo $_REQUEST['queryId'] ?>');" style=" cursor:pointer;" /> </td>
		<?php }else{ ?>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
	<?php } ?>
    <td><?php echo $editfirstName.' '.$editlastName; ?></td>
  </tr>
  
</table>
</div></td>
    <td align="right"><?php if($editpermission==1){ ?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;">
		<?php if($_REQUEST['guestList']==3){ ?>
			<input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="editviewGuest('<?php echo $_GET['id']; ?>&BToCIdedit=1','<?php echo $_GET['guestList']; ?>','<?php echo $_REQUEST['queryId']; ?>');" />
			 <?php }else{ ?>
		<input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>&BToCIdedit=2');" />
				<?php } ?>
	</td>
      </tr>
      
    </table><?php } ?></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">

 <div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Contact Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv">
	  <div class="gridlable">Full Name</div> 
	  <div class="gridtext"><?php echo getNameTitle($editcontacttitleId).' '.$editfirstName.' '.$editlastName; ?></div>
	</label>
	</div>
	<div class="griddiv" style="display:none;"><label><div class="gridlable">Designation</div>
	<div class="gridtext"><?php echo getDesignation($editdesignationId); ?></div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Date of Birth</div>
	<div class="gridtext"><?php if($editbirthDate=='1970-01-01'){ }else{ echo date("d-m-Y", strtotime($editbirthDate)); } ?></div>
	<!-- <div class="gridtext"><?php if($editbirthDate!=''){ echo date("d-m-Y", strtotime($editbirthDate)); } ?></div> -->
	 
	</label>
	</div>
	
 <div class="griddiv"><label><div class="gridlable">Anniversary Date</div>
 	<div class="gridtext"><?php if($editanniversaryDate=='1970-01-01'){ }else{ echo date("d-m-Y", strtotime($editanniversaryDate)); } ?></div>
	<!-- <div class="gridtext"><?php if($editanniversaryDate!=''){ echo date("d-m-Y", strtotime($editanniversaryDate)); } ?></div> -->
	 
	</label>
	</div>
	
	 <div class="griddiv"><label>
	 <div class="gridlable">Mobile / Landline / Fax</div>
	 <div class="gridtext"> 
  <?php 
$phonen=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' masterId='.$id.' and sectionType="contacts" order by id asc';  
$rs=GetPageRecord($select,'phoneMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
  <div style="margin-bottom:2px;">
    <?php echo $resListing['phoneNo']; ?><span style="color:#7b7b7b; font-size:12px;"> - <?php echo getPhoneType($resListing['phoneType']); ?> <?php if($resListing['primaryvalue']==1){ ?><img src="images/greencheck.png" style="position: absolute; margin-left: 8px;" /><?php } ?></span>  </div>
  <?php } ?>
</div>
	 
	</label>
	</div>
	 
	 
	 <div class="griddiv"><label>
	 <div class="gridlable">Email</div>
	 <div class="gridtext"> 
  <?php 
$phonen=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' masterId='.$id.' and sectionType="contacts" order by id asc';  
$rs=GetPageRecord($select,'emailMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
  <div style="margin-bottom:2px;">
    <a href="mailto:<?php echo $resListing['email']; ?>"><?php echo $resListing['email']; ?></a><span style="color:#7b7b7b; font-size:12px;"> - <?php echo getEmailType($resListing['emailType']); ?> <?php if($resListing['primaryvalue']==1){ ?><img src="images/greencheck.png" style="position: absolute; margin-left: 8px;"/><?php } ?></span>  </div>
  <?php } ?>
</div>
	 
	</label>
	</div>
	<!-- <h3>Emergency Details</h3> -->
	<div class="griddiv"><label><div class="gridlable">Emergency Name</div>
 	<div class="gridtext"><?php echo $editresult['emergencyName']; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Emergency Relation</div>
 	<div class="gridtext"><?php echo $editresult['emergencyRelation']; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Emergency Contact</div>
 	<div class="gridtext"><?php echo $editresult['emergencyContact']; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Facebook</div>
 	<div class="gridtext"><?php echo $editfacebook; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Twitter</div>
 	<div class="gridtext"><?php echo $edittwitter; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">LinkedIn</div>
 	<div class="gridtext"><?php echo $editlinkedIn; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Instagram</div>
 	<div class="gridtext"><?php echo $editresult['Instagram']; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Skype</div>
 	<div class="gridtext"><?php echo $editresult['SkypeId']; ?></div>
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">MSN Id</div>
 	<div class="gridtext"><?php echo $editresult['MSNId']; ?></div>
	</label>
	</div>
	
	 	<div class="griddiv"><label>
	<div class="gridlable">Created By </div>
		<div class="gridtext"><?php 
$select=''; 
$where=''; 
$rs='';  
$select='firstName,lastName';   
$where='id="'.$addedBy.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($userss=mysqli_fetch_array($rs)){  

echo $userss['firstName'].' '.$userss['lastName'];

}
?><div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo date('d M Y',strtotime($dateAdded));?></div>
</div>
	</label>
	</div>
	
	 	
	<?php if($modifyDate!='0'){ ?>
	<div class="griddiv"><label>
	<div class="gridlable">Modified By </div>
		<div class="gridtext"><?php 
$select=''; 
$where=''; 
$rs='';  
$select='firstName,lastName';   
$where='id="'.$modifyBy.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($userss=mysqli_fetch_array($rs)){  

echo $userss['firstName'].' '.$userss['lastName'];

}
?>
<div style="font-size:12px; margin-top:2px; color:#999999;"><?php if($modifyDate!='0'){ echo showdatetime($modifyDate,$loginusertimeFormat); } ?></div>
</div>
	</label>
	</div>
	<?php } ?>	
	 </td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> 
	
	<div class="griddiv"><label><div class="gridlable">Market Type</div>
	<div class="gridtext">
	<?php    
	$rs=GetPageRecord('*','marketMaster','id="'.$editresult['marketType'].'"'); 
	while($resListing=mysqli_fetch_array($rs)){   
	echo strip($resListing['name']);
	} ?>
	
	</div> 
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Nationality</div>
	<div class="gridtext">
	<?php    
	$rs=GetPageRecord('*','nationalityMaster','id="'.$nationality.'"'); 
	while($resListing=mysqli_fetch_array($rs)){   
	echo strip($resListing['name']);
	} ?>
	
	</div> 
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Tour Type</div>
	<div class="gridtext">
	<?php    
	$rs=GetPageRecord('*','tourTypeMaster','id="'.$tourType.'"'); 
	while($resListing=mysqli_fetch_array($rs)){   
	echo strip($resListing['name']);
	} ?>
	
	</div> 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Meal Preference</div>
	<div class="gridtext">
	 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' id="'.$editresult['mealPreference'].'" ';  
$rs=GetPageRecord($select,'mealPreference',$where); 
while($resListing=mysqli_fetch_array($rs)){   
echo strip($resListing['name']);
} ?>
	
	</div> 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Holiday Preference</div>
	<div class="gridtext">
	 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' id="'.$editresult['holyDayPacId'].'" ';  
$rs=GetPageRecord($select,_PREHOLIDAYPAC_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){   
echo strip($resListing['name']);
} ?>
	
	</div>
	 
	</label>
	</div>

	
	<div class="griddiv"><label><div class="gridlable">Special Assistance</div>
	<div class="gridtext">
	 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' id="'.$editresult['physicalCondition'].'"  ';  
$rs=GetPageRecord($select,'physicalCondition',$where); 
while($resListing=mysqli_fetch_array($rs)){   
echo strip($resListing['name']);
} ?>
	
	</div>
	 
	</label>
	</div>
	
	<div class="griddiv"><label><div class="gridlable">Seat Preference</div>
	<div class="gridtext">
	 <?php echo $editresult['seatPreference']; ?>
	
	</div>
	 
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">Accomodation Preference</div>
	<div class="gridtext">
	 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' id="'.$editresult['preAccomodationMaster'].'"  ';  
$rs=GetPageRecord($select,_PRE_ACCOMODATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){   
echo strip($resListing['name']);
} ?>
	
	</div>
	 
	</label>
	</div>

	
<div class="griddiv"><label><div class="gridlable">Country</div>
	<div class="gridtext"><?php echo getCountryName($editcountryId); ?></div>
	 
	</label>
	</div>	<div class="griddiv"><label><div class="gridlable">State</div>
	<div class="gridtext"><?php echo getStateName($editstateId); ?></div>
	 
	</label>
	</div>
	
	  <div class="griddiv">
	    <div class="gridlable">City </div>
	    <div class="gridtext"> 
	
<?php echo getCityName($editcityId); ?></div>
	 </label>
	</div>
	
	<div class="griddiv">
	  <div class="gridlable">Address </div>
	  <div class="gridtext"> 
	
<?php echo $addressInfo; ?></div>
	 </label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Remark 1</div>
		<div class="gridtext"><?php echo $editremark1; ?></div>
	</label>
	</div>
	 <div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Remark 2 </div>
	   <div class="gridtext"><?php echo $editremark2; ?></div>
	   </div>

	   <div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Remark 3 </div>
	   <div class="gridtext"><?php echo $editremark3; ?></div>
	   </div>
	 
	  <div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Pin Code  </div>
	   <div class="gridtext"><?php echo $editpinCode; ?></div>
	   </div><div class="griddiv"><div class="gridlable">Sales&nbsp;Person </div><div class="gridtext"> 
	
<?php echo getUserName($editassignTo); ?></div>
	 </label>
	</div>	
	
 

		    </td>
  </tr>
  <?php if($editresult['familyCode']!=''){ ?>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;">
		<div class="innerbox" style="border-top:1px #eee solid; padding-top:30px;">
      		<h2><i class="fa fa-users" aria-hidden="true"></i> Family Members <?php if($editresult['familyCode']!=''){ ?>(<?php echo strip($editresult['familyCode']); ?>) <?php } ?>&nbsp;&nbsp;&nbsp;<a href="showpage.crm?module=contacts&add=yes&fc=<?php echo $editresult['familyCode']; ?>" style="text-decoration:underline; font-size:13px;">+ Add Family Member</a>
      		</h2>
    	</div>
	<div style="padding:10px; border:1px solid #ccc; background-color:#F8F8F8; margin-bottom:30px;"><table width="100%" border="0" cellpadding="8" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="tablesorter gridtable">
  <thead>
    <tr>
      <th width="30%" align="left" class="header" style="padding-bottom:10px;" >Name</th>
     <th width="20%" align="left" class="header " style="padding-bottom:10px;" >Family Relation</th>
     <th width="20%" align="left" class="header " style="padding-bottom:10px;" >Phone</th>
     <th width="20%" align="left" class="header " style="padding-bottom:10px;" >Email</th>
    </tr>
   </thead>
   <tbody>
  <?php 
	  $nod=1;
$select='*';
$where='  familyCode="'.$editresult['familyCode'].'" order by id desc'; 
$rs=GetPageRecord($select,_CONTACT_MASTER_,$where); 
while($familyrelation=mysqli_fetch_array($rs)){
?>	 
  <tr> 
    <td width="30%" align="left"><a href="showpage.crm?module=contacts&view=yes&id=<?php echo encode($familyrelation['id']); ?>"><?php echo getNameTitle($familyrelation['contacttitleId']).' '.$familyrelation['firstName'].' '.$familyrelation['lastName']; ?></a></td>
    <td width="20%" align="left"><span style="    padding: 3px 5px 2px;
    color: #FFFFFF;
    text-transform: uppercase;
    font-size: 12px;
    background-color: #007fbc;
    float: left;
    border-radius: 3px;"><?php echo strip($familyrelation['familyRelation']); ?></span></td>
    <td width="20%" align="left"><?php echo getPrimaryPhone($familyrelation['id'],'contacts'); ?></td>
    <td width="20%" align="left"><a href="mailto:<?php echo getPrimaryEmail($familyrelation['id'],'contacts'); ?>"><?php echo getPrimaryEmail($familyrelation['id'],'contacts'); ?></a></td>
  </tr> 
	
	<?php $nod++;} ?>
</tbody></table></div>
<?php if($nod==1){ ?>
<div style="text-align:center; padding:10px; background-color:#f9f9f9;">No Data</div>
 <?php } ?>
	</td>
    
  </tr>
   <tr><?php } ?>

	<!-- Document details -->

    <td colspan="2" align="left" valign="top" style="padding-right:20px;"><div class="griddiv" style="border-bottom:0px;">
	<strong>Contact Documents</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<!-- <a onclick="alertspopupopen('action=addeditdocument&sectionType=contacts&masterId=<?php echo $_GET['id']; ?>','700px','auto');"  style="text-decoration:underline; position:absolute; right:0px;">+ Add Document</a> -->
	 <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm" style="display:none;">
	  <input name="uploaddocuments" type="file" id="uploaddocuments" onchange="uploaddocumentfunc();" />
	  <input name="editId" type="hidden" id="editId" value="<?php echo $_GET['id']; ?>" />
	  <input name="action" type="hidden" id="action" value="attachdocument" />
	  <input name="sectionType" type="hidden" id="sectionType" value="contacts" />
	  </form>
	  <script>
	  function deletedocument(id){
	   $('#loaddocuments').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
	   
	  $('#loaddocuments').load('loaddocuments.php?id=<?php echo $id; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
	  }
	  
	  function deleteconfirm(id){
	  if (confirm("Do you want to delete this document?")){
    deletedocument(id);
	}
	  }
	  
	  function uploaddocumentfunc(){
	  $('#addeditfrm').submit();
	  $('#loaddocuments').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>');
	  }
	  
	  $('#my-button').click(function(){
    $('#uploaddocuments').click();
});
	  function loaddocumentfunc(){
$('#loaddocuments').load('loaddocuments.php?id=<?php echo $id; ?>&sectionType='+$('#sectionType').val());
}
	  </script>
	  </div>
	</td>
    
  </tr> <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" id="loaddocuments">Loading... </td>
    
  </tr>

  <!-- <tr>
    <td colspan="2" align="left" valign="top"  >
    	<div class="innerbox" style="border-top:1px #eee solid; padding-top:30px;">
      		<h2>Bank Details &nbsp;&nbsp;&nbsp;<a  onclick="alertspopupopen('action=addeditbankinfo&sectionType=contacts&masterId=<?php echo $_GET['id']; ?>','700px','auto');" style="text-decoration:underline; font-size:13px;">+ Add Bank Detail</a>
      		</h2>
    	</div>
	</td>
  </tr> -->
  <!-- <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" >&nbsp; </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" id="loadbankdetails">Loading...</td>
    </tr> -->
	
	<!-- <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" id="loadsalesmodule" >Loading...</td>
  </tr> -->
</table>
<script>
	   	loaddocumentfunc();
	   
	   </script> 
<script>
function funloadsalesmodule(){
$('#loadsalesmodule').load('loadsalesmodule.php?id=<?php echo $editsupId; ?>&clientType=2&parentType=lead');
}
funloadsalesmodule();


// function deletebank(id){
// 	   $('#loadbankdetails').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
// 	  $('#loadbankdetails').load('loadbankdetails.php?id=<?php echo $id; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
// 	  }
	  
// 	  function deleteconfirmbank(id){
// 	  if (confirm("Do you want to delete this bank detail?")){
//     deletebank(id);
// }
// 	  }

// function loadbankdetailsfunc(){
// $('#loadbankdetails').load('loadbankdetails.php?id=<?php echo $id; ?>&sectionType='+$('#sectionType').val());
// }
// loadbankdetailsfunc();

</script>

</div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op2');
</script>

<script>
	 function editviewGuest(guestId,contactType,queryId){
    setupbox('showpage.crm?module=contacts&add=yes&id='+guestId+'&guestList='+contactType+'&queryId='+queryId);
  }

  function cancelGuest(contactType,queryId){
    setupbox('showpage.crm?module=contacts&guestList='+contactType+'&queryId='+queryId);
  }
</script>