<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}

 

if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

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
$bussinessTypeId=clean($editresult['bussinessType']);
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
$editsupId=clean($editresult['id']);
$editcompanyCategory=clean($editresult['companyCategory']);
$paymentTerm=clean($editresult['paymentTerm']);
$creditlimit=clean($editresult['creditlimit']);
$editcompanyLogo=clean($editresult['companyLogo']);
$editmarketType=clean($editresult['marketType']);
$edittourType=clean($editresult['tourType']);
$editnationality=clean($editresult['nationality']);

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
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td><?php echo $editname; ?></td>
  </tr>
  
</table>
</div></td>
    <td align="right"><?php if($editpermission==1){ ?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>');" /></td>
      </tr>
      
    </table><?php } ?></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">

 <div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>Company Information</h2></div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<?php if($editcompanyLogo!=''){ ?>
		<div class="griddiv">
		<div class="gridlable">Company Logo</div> 
		<div class="gridtext"><img src="<?php echo $fullurl; ?>agentLogo/<?php echo $editcompanyLogo; ?>" alt="editcompanyLogo" width="220" /></div>
	</label>
	</div> <?php } ?>
	<div class="griddiv">
		<div class="gridlable">Business Type</div> 
		<div class="gridtext"><?php 
		if($bussinessTypeId!=''){ 
		$rs='';   
		$rs=GetPageRecord('*','businessTypeMaster','id='.$bussinessTypeId.''); 
		$resListing21=mysqli_fetch_array($rs);  
		echo strip($resListing21['name']);   
		} ?></div>
	</label>
	</div>
	<div class="griddiv">
	  <div class="gridlable">Company Type</div> 
	<div class="gridtext"><?php 
  if($editcompanyTypeId!=''){
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editcompanyTypeId.'';  
$rs=GetPageRecord($select,_COMPANY_TYPE_MASTER_,$where); 
while($resListing2=mysqli_fetch_array($rs)){  
 echo strip($resListing2['name']);   } } ?></div>
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Company</div>
	<div class="gridtext"><?php echo $editname; ?></div>
	 
	</label>
	</div>
	
	<!-- PAN And TRN NO. sec  -->
	<div class="griddiv"><label><div class="gridlable">GSTN</div>
	<div class="gridtext" style="text-transform:uppercase;"><?php echo $editgstn; ?></div>
	 
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">PAN No. </div>
	<div class="gridtext" style="text-transform:uppercase;"><?php echo $editpannumber; ?></div>
	 
	</label>
	</div>

	<div class="griddiv"><label><div class="gridlable">TRN No.</div>
	<div class="gridtext" style="text-transform:uppercase;"><?php echo $edittrnnumber; ?></div>
	 
	</label>
	</div>
	
	
	<div class="griddiv"><label><div class="gridlable">Credit Limit</div>
	<div class="gridtext" style="text-transform:uppercase;"><?php echo $creditlimit; ?></div>
	 
	</label>
	</div>
	
	
	<?php if($editagreement!=''){ ?><div class="griddiv">
	<label><div class="gridlable">Agreement</div>
	<div class="gridtext"> <a href="download/<?php echo $editagreement; ?>" target="_blank"><div class="commattachedbox" style="    padding-top: 2px;
    padding-bottom: 4px;
    margin-bottom: 5px;"><strong>Download Attachment</strong></div>
	 </a></div></label>
	
	 
	</div> <?php } ?>
	 
	 <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="margin-bottom:10px;">
  <tr>
    <td width="100" align="center"><strong>Division</strong></td>
    <td width="100" align="center"><strong>Contact Person</strong></td>
    <td width="100" align="center"><strong>Designation</strong></td>
    <td width="100" align="center"><strong>Phone</strong></td>
    <td width="100" align="center"><strong>Email</strong></td>
  </tr>
	<?php
	$select='*';    
$where=' corporateId="'.$id.'" and contactPerson!="" and deletestatus=0 order by id asc';  
$rs=GetPageRecord($select,'contactPersonMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){
	 ?> 	
  <tr>
    <td width="100" align="center"> <?php  
$selectd='*';    
$whered=' id="'.$resListing['division'].'" and deletestatus=0 and status=1 order by name asc';  
$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
$resListingd=mysqli_fetch_array($rsd);
echo $resListingd['name'];

?></td>
    <td width="100" align="center"><?php echo $resListing['contactPerson']; ?></td>
    <td width="100" align="center"><?php echo $resListing['designation']; ?></td>
    <td width="100" align="center"><?php echo $resListing['countryCode'].'&nbsp;'.decode($resListing['phone']); ?></td>
    <td width="100" align="center"><?php echo decode($resListing['email']); ?></td>
  </tr> 
	 <?php } ?>
</table>
	
	
	
	 	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> 
	<div style="margin-bottom:10px; font-size:13px; color:#8a8a8a; position:relative;">Address </div>
	
	<!-- if address not inserted -->
	<?php if($editcountryId==''){?>
	<div id="loadaddress" style="margin-bottom:30px;"></div>
	<script>
	function loadaddress(dltid){
	$('#loadaddress').load('loadaddress.php?addressParent=<?php echo $editsupId; ?>&addressType=corporate&dltid='+dltid+'&view=1');
	}
	loadaddress('0');
	</script>
	<?php }else{ ?>	
	<div style="display:none1;">
<div class="griddiv"><label><div class="gridlable">Country</div>
	<div class="gridtext"><?php echo getCountryName($editcountryId); ?></div>
	 <!-- editsupId -->
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
	  <div class="gridlable">Address 1 </div>
	  <div class="gridtext"> 
	
<?php echo $editaddress1; ?></div>
	 </label>
	</div>
	<?php if($editaddress2!=''){?>
	<div class="griddiv"><label>
	<div class="gridlable">Address 2</div>
		<div class="gridtext"><?php echo $editaddress2; ?></div>
	</label>
	</div>
	<?php } ?>
	<?php if($editaddress3!=''){?>
	 <div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Address 3 </div>
	   <div class="gridtext"><?php echo $editaddress3; ?></div>
	   </div>
	   <?php } ?>
	 
	  <div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Pin Code  </div>
	   <div class="gridtext"><?php echo $editpinCode; ?></div>
	   </div></div>
	   <?php } ?>
	   <div class="griddiv"><div class="gridlable">Sales Person </div><div class="gridtext"> 
	
<?php echo getUserName($editassignTo); ?></div>
	 </label>
	</div>
	
	
	
		<div class="griddiv"><div class="gridlable">Market Type</div><div class="gridtext"> 
	
<?php if($editmarketType>0){ echo getMarketType($editmarketType); }else{ echo 'All'; } ?></div>
	 </label>
	</div> 

	<div class="griddiv"><div class="gridlable">Nationality</div><div class="gridtext"> 
	
<?php if($editnationality>0){
$rs=GetPageRecord('name','nationalityMaster','1 and id="'.$editnationality.'"'); 
$nationName=mysqli_fetch_array($rs);  

 echo $nationName['name']; } ?></div>
	 </label>
	</div> 

	<div class="griddiv"><div class="gridlable">Tour Type</div><div class="gridtext"> 
	
<?php if($edittourType>0){
$rs=GetPageRecord('name','tourTypeMaster','1 and id="'.$edittourType.'"'); 
$tourName=mysqli_fetch_array($rs);  

 echo $tourName['name']; } ?></div>
	 </label>
	</div> 	
	
	<div class="griddiv"><div class="gridlable">Category </div><div class="gridtext"> 
	
<?php  if($editcompanyCategory==1){ echo 'Big'; }  if($editcompanyCategory==2){ echo 'Medium'; } if($editcompanyCategory==3){ echo 'Small'; }?></div>
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
	
	<?php
include "config/mail.php";  
 

$email = ''.getPrimaryEmail($editresult['id'],'corporate').'';
$status = 'subscribed'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
$list_id = '1c4d75633a'; // where to get it read above
$api_key = 'f766b68a4ff1b82b215fc3586a871c47-us17'; // where to get it read above
$merge_fields = array('FNAME' => ''.$editname.'','LNAME' => '','ADDRESS' => 'delhi','PHONE' => ''.getPrimaryPhone($editresult['id'],'corporate').'');
$tags = 'corporate';
 
rudr_mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields, $tags); 
?>
		    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;">
    	<div class="griddiv" style="border-bottom:0px;">
	<strong>Company Documents</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a  onclick="alertspopupopen('action=addeditdocument&sectionType=corporate&masterId=<?php echo $_GET['id']; ?>','700px','auto');" style="text-decoration:underline; position:absolute; ">+ Add Document</a> 
	  <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm" style="display:none;">
	  <input name="uploaddocuments" type="file" id="uploaddocuments" onchange="uploaddocumentfunc();" />
	  <input name="editId" type="hidden" id="editId" value="<?php echo $_GET['id']; ?>" />
	  <input name="action" type="hidden" id="action" value="attachdocument" />
	  <input name="sectionType" type="hidden" id="sectionType" value="corporate" />
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
	  <div id="loaddocuments">
	  Loading...	   </div>
	  <script>
	   	loaddocumentfunc();
	   
	   </script>

    </td>
    
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  ><div class="innerbox" style="border-top:1px #eee solid; padding-top:30px;">
      <h2 style="margin-bottom:20px;">Bank Details &nbsp;&nbsp;&nbsp;<a  onclick="alertspopupopen('action=addeditbankinfo&sectionType=corporate&masterId=<?php echo $_GET['id']; ?>','700px','auto');" style="text-decoration:underline; font-size:13px;">+ Add Bank Detail</a></h2>
    </div></td>
    </tr>
  
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" id="loadbankdetails">Loading...</td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" id="loadsalesmodule" >Loading...</td>
  </tr>
</table>
<script>

function funloadsalesmodule(){
$('#loadsalesmodule').load('loadsalesmodule.php?id=<?php echo $editsupId; ?>&clientType=1&parentType=lead');
}
funloadsalesmodule();

function deletebank(id){
	   $('#loadbankdetails').html('<div style="text-align:center; padding:10px; backgroud-color:#fff;"><img src="images/ajax-loader.gif" /></div>'); 
	  $('#loadbankdetails').load('loadbankdetails.php?id=<?php echo $id; ?>&dltid='+id+'&sectionType='+$('#sectionType').val());
	  }
	  
	  function deleteconfirmbank(id){
	  if (confirm("Do you want to delete this bank detail?")){
    deletebank(id);
}
	  }

function loadbankdetailsfunc(){
$('#loadbankdetails').load('loadbankdetails.php?id=<?php echo $id; ?>&sectionType='+$('#sectionType').val());
}
loadbankdetailsfunc();
</script>

</div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op2');
</script>
