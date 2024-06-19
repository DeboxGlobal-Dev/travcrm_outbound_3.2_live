<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$editname=clean($editresult['name']);
$editaliasname=clean($editresult['aliasname']);
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
$editcategoryId=clean($editresult['categoryId']);  
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$editpinCode=clean($editresult['pinCode']);
$editgstn=clean($editresult['gstn']);
$editagreement=clean($editresult['agreement']);
$destinationlist=clean($editresult['destinationlist']);
$locationMap=clean($editresult['locationMap']);
$supplierMainType=clean($editresult['supplierMainType']);
$airlinesType=clean($editresult['airlinesType']);
$otherType=clean($editresult['otherType']);
$transferType=clean($editresult['transferType']);
$ferryType=clean($editresult['ferryType']);
$cruiseType=clean($editresult['cruiseType']);
$sightseeingType=clean($editresult['sightseeingType']); 
$paymentTerm=clean($editresult['paymentTerm']); 
$editsupId=clean($editresult['id']);


$destinationId=clean($editresult['destinationId']);
$destinationWise = $editresult['destinationWise'];
$destCountryId = $editresult['destCountryId'];
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
<script>
function goBack() {
    window.history.back();
}
</script>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:20px;"><table border="0" cellpadding="0" cellspacing="0">
  <tr> 
  <?php if($_REQUEST['quotSupp']=='yes'){ ?>
	<td width="7%" align="left">
	<a name="addnewuserbtn" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['queryId'] ?>&quotationId=<?php echo $_REQUEST['quotationId'] ?>&b2bquotation=1"><input type="button" name="Submit22" value="Back to Quotation" class="whitembutton"></a>
	</td>
	<?php }else{ ?>

	<td width="7%" align="left">
       <a name="addnewuserbtn" href="showpage.crm?module=suppliers"><input type="button" name="Submit22" value="Back" class="whitembutton"></a>    
     </td>
	 <?php } ?>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $editname; ?></td>
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
    <td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>Supplier Information</h2></div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Supplier Name</div>
	<div class="gridtext"><?php echo $editname; ?></div>
	<div class="gridlable">Alias Name</div>
	<div class="gridtext"><?php echo $editaliasname; ?></div>
	 
	</label>
	</div> 
	
	<div class="griddiv">
	  <div class="gridlable">Supplier Services</div> 
	<div class="gridtext"><?php echo getsuppliersTypeNameList($editsupId); ?><?php if($otherType==13){ ?>, Other<?php } ?></div>
	</label>
	</div>
	
	<div class="griddiv" style="display:nonew;"><label><div class="gridlable">Payment Terms</div>
	<div class="gridtext" style="text-transform:uppercase;"><?php echo ($paymentTerm == 1)?'Cash':'Credit'; ?></div>
	</label>
	</div>
	
	<div class="griddiv" style="display:none;"><label><div class="gridlable">GSTN</div>
	<div class="gridtext" style="text-transform:uppercase;"><?php echo $editgstn; ?></div>
	 
	</label>
	</div>
	
	<?php if($editagreement!=''){ ?><div class="griddiv">
	<label><div class="gridlable">Agreement</div>
	<div class="gridtext"> <a href="download/<?php echo $editagreement; ?>" target="_blank"><div class="commattachedbox" style="    padding-top: 2px;
    padding-bottom: 4px;
    margin-bottom: 5px;"><strong>Download Attachment</strong></div>
	 </a></div></label>
	
	 
	</div> <?php } ?>
	<div class="griddiv"> 
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2">
  <tr>
    <td bgcolor="#F2F2F2"><strong>Division</strong></td>
    <td bgcolor="#F2F2F2"><strong>Contact Person </strong></td>
    <td bgcolor="#F2F2F2"><strong>Designation</strong></td>
    <td bgcolor="#F2F2F2"><strong>Phone</strong></td>
    <td bgcolor="#F2F2F2"><strong>Email</strong></td>
  </tr>
  <?php 
$rs=GetPageRecord('*','suppliercontactPersonMaster',' corporateId='.$id.' and contactPerson!="" and deletestatus=0 order by id asc'); 
while($resListing=mysqli_fetch_array($rs)){  
 
$rsd=GetPageRecord('*',_DIVISION_MASTER_,' id="'.$resListing['division'].'" and deletestatus=0 and status=1 order by name asc'); 
$resListingd=mysqli_fetch_array($rsd);


   ?>
  <tr>
    <td><?php echo strip($resListingd['name']); ?></td>
    <td><?php echo $resListing['contactPerson']; ?></td>
    <td><?php echo $resListing['designation']; ?></td>
    <td><?php echo $resListing['countryCode']; ?>&nbsp;<?php echo decode($resListing['phone']); ?></td>
    <td><?php echo decode($resListing['email']); ?></td>
  </tr>
  <?php  } ?>
</table>

	</div>
	 <!--<div class="griddiv"><label>
	 <div class="gridlable">Mobile / Landline / Fax</div>
	 <div class="gridtext"> 
  <?php 
$phonen=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' masterId='.$id.' and sectionType="suppliers" order by id asc';  
$rs=GetPageRecord($select,_PHONE_MASTER_,$where); 
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
$where=' masterId='.$id.' and sectionType="suppliers" order by id asc';  
$rs=GetPageRecord($select,_EMAIL_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
  <div style="margin-bottom:2px;">
    <a href="mailto:<?php echo $resListing['email']; ?>"><?php echo $resListing['email']; ?></a><span style="color:#7b7b7b; font-size:12px;"> - <?php echo getEmailType($resListing['emailType']); ?> <?php if($resListing['primaryvalue']==1){ ?><img src="images/greencheck.png" style="position: absolute; margin-left: 8px;"/><?php } ?></span>  </div>
  <?php } ?>
</div>
	 
	</label>
	</div>-->
	
	
	
	 
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
?><div style="font-size:12px; margin-top:2px; color:#999999;"><?php echo showdatetime($dateAdded,$loginusertimeFormat);?></div>
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
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> <?php if($editcompanyTypeId==1){ ?> <?php } ?>
	
	<div class="griddiv">
	<table width="100%" border="0" cellspacing="0" cellpadding="5"> 
		<?php 
		if ($destinationWise == 1 && $destCountryId > 0) { ?>
		  <tr>
		    <td width="11%"><strong>Destination: </strong></td>
		    <td width="89%"><?php echo 'All Destination of '.getCountryName($destCountryId);  ?></td>
		  </tr>
		  <?php
		}elseif ($destinationWise == 2) { 
			?>
		  <tr>
		    <td width="11%"><strong>Destination: </strong></td>
		    <td width="89%"><?php echo 'All Destination'; ?></td>
		  </tr>
		  <?php
		}elseif ($destinationWise == 0) {
			?>
		  <tr>
		    <td width="11%"><strong>Destination: </strong></td>
		    <td width="89%">
		    	<?php 
		    	$destinationArray = explode(',', strval($destinationId));
          $uniqueDestinations = array_unique($destinationArray);
          $destStr = '';
          foreach ($uniqueDestinations as $destId) {
              $destStr .= getDestination($destId) . ',';
          }
          echo rtrim($destStr, ',');
					?>
		    </td>
		  </tr>
		  <?php
		}
		?>
	</table>  
	</div>
	
	<?php if($editresult['expensesType']!=0){ ?>
	<div class="griddiv"><label>
	<div class="gridlable">Expenses Type</div>
	<div class="gridtext"><?php 
$select4=''; 
$where4=''; 
$rs4='';  
$select4='*';    
$where4=' id='.$editresult['expensesType'].'';  
$rs4=GetPageRecord($select4,'expensesType',$where4); 
while($resListing4=mysqli_fetch_array($rs4)){  

 echo strip($resListing4['name']); 
 
  } ?></div>
	 
	</label>
	</div>
	<?php } ?>
	<div style="margin-bottom:10px; font-size:13px; color:#8a8a8a; position:relative;">Address </div>
	<div id="loadaddress" style="margin-bottom:30px;"></div>
	<script>
	function loadaddress(dltid){
	$('#loadaddress').load('loadaddress.php?addressParent=<?php echo $editsupId; ?>&addressType=supplier&dltid='+dltid+'&view=1');
	}
	loadaddress('0');
	</script>
	 
	
	<div style="display:none;">
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
	  <div class="gridlable">Address 1 </div>
	  <div class="gridtext"> 
	
<?php echo $editaddress1; ?></div>
	 </label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Address 2</div>
		<div class="gridtext"><?php echo $editaddress2; ?></div>
	</label>
	</div>
	 <div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Address 3 </div>
	   <div class="gridtext"><?php echo $editaddress3; ?></div>
	   </div>
	 
	  <div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Pin Code  </div>
	   <div class="gridtext"><?php echo $editpinCode; ?></div>
	   </div></div>
	   <?php if($locationMap!=''){ ?><div class="griddiv">
	   <label> </label>
	   <div class="gridlable">Location (MAP)</div>
	   <div class="gridtext" style="word-break: break-all;"><a href="<?php echo $locationMap; ?>" target="_blank"><strong>View Location </strong></a></div>
	   </div><?php } ?><!--<div class="griddiv"><div class="gridlable">Sales Person </div><div class="gridtext"> 
	
<?php echo getUserName($editassignTo); ?></div>
	 </label>
	</div>-->	 	
	
	 	    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;display:none;">
	 <h2 style="margin-bottom:10px;">Property Picture</h2>
	<div style="background-color:#f8f8f8; padding:20px; overflow:hidden; margin-bottom:30px;">
	<script>
	function removepicture(id){
	$('#actiondiv').load('frmaction.php?action=removepicture&&parentId=<?php echo $id; ?>&did='+id);
	}
	
	</script>
	<?php 
$g=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' parentId='.$id.' and galleryType="supplier" order by id desc';  
$rs=GetPageRecord($select,_IMAGE_GALLERY_MASTER_,$where); 
while($gallery=mysqli_fetch_array($rs)){  

?>
<div style="background-color:#FFFFFF;  border-radius: 5px; padding:0px; float:left; margin:10px; overflow:hidden; width:150px; height:90px; position:relative;"><img src="dirfiles/<?php echo $gallery['name']; ?>" style="width:100%;" />
<a style="color:#FF0000 !important;  font-size:12px;" onclick="if(confirm('Are you sure you want delete this Picture?')) removepicture('<?php echo $gallery['id']; ?>');">
<div style="width: 20px;height: 20px;background-color:#FFFFFF;position:absolute;right:2px;bottom:2px;padding: 4px;border-radius: 5px; text-align: center; cursor:pointer;"><i class="fa fa-trash" style="font-size: 18px;color:#FF0000;"></i></div></a>
</div>

 
<?php $g++;} ?>



<?php if($g==1){ ?>

<div style="background-color:#FFFFFF; padding:20px; text-align:center; font-size:15px;">No Picture Uploaded<div style="text-align:center; margin-top:10px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Upload Picture" style=" background-color:#45b558 !important; border:#45b558 1px solid !important; margin-left:0px;" onclick="uploadgallery();"></div></div>

<?php } else { ?>
<div style="background-color:#45b558;  color:#fff; cursor:pointer; border-radius: 5px; text-align:center; padding:0px; float:left; margin:10px; overflow:hidden; width:150px; height:90px;" onclick="uploadgallery();"><i class="fa fa-fw fa-plus" style="font-size:55px; margin-top:21px;"></i></div>
<?php } ?>

 <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="imageaddeditfrm" target="actoinfrm" id="imageaddeditfrm" style="display:none;">
 <input name="imagename" id="imagename" type="file" accept="image/x-png,image/gif,image/jpeg" onchange="$('#imageaddeditfrm').submit();$('#pageloader').hide();$('#pageloading').hide();" />
 <input name="action" id="action" type="hidden" value="uploadgalleryimage" />
 <input name="parentId" id="parentId" type="hidden" value="<?php echo $id; ?>" />
 </form>
<script>
function uploadgallery(){
$('#imagename').trigger('click'); 
}
</script>	
	
	</div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"><div class="griddiv" style="border-bottom:0px;">
	<strong>Company Documents</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a id="my-button" style="text-decoration:underline; position:absolute; ">+ Add Document</a> 
	  <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm" style="display:none;">
	  <input name="uploaddocuments" type="file" id="uploaddocuments" onchange="uploaddocumentfunc();" />
	  <input name="editId" type="hidden" id="editId" value="<?php echo $_GET['id']; ?>" />
	  <input name="action" type="hidden" id="action" value="attachdocument" />
	  <input name="sectionType" type="hidden" id="sectionType" value="suppliers" />
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
	  </script>
	  </div>
	  <div id="loaddocuments">
	  Loading...	   </div>
	   <script>
	   $('#loaddocuments').load('loaddocuments.php?id=<?php echo $id; ?>&sectionType='+$('#sectionType').val());
	   </script></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  ><div class="innerbox" style="border-top:1px #eee solid; padding-top:30px;">
      <h2>Bank Details &nbsp;&nbsp;&nbsp;<a  onclick="alertspopupopen('action=addeditbankinfo&sectionType=suppliers&masterId=<?php echo $_GET['id']; ?>','700px','auto');" style="text-decoration:underline; font-size:13px;">+ Add Bank Detail</a></h2>
    </div></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;" id="loadbankdetails">Loading...</td>
    </tr>
</table>
<script>

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
