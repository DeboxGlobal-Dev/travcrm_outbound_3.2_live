<?php
include "inc.php"; 
include "config/logincheck.php";  
?>
 <?php if($_GET['action']=='addedit_countrymaster' && $_GET['sectiontype']=='countrymaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_COUNTRY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Country </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_countrymaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
if($_GET['action']=='addedit_statemaster' && $_GET['sectiontype']=='statemaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_STATE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
$editcountryId=clean($editresult['countryId']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> State </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Country<span class="redmind"></span></div>
	<select id="countryId" name="countryId" class="gridfield validate" displayname="Country" autocomplete="off" onchange="selectstate();" >
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
</select>
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_statemaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php } 
	
if($_GET['action']=='addedit_citymaster' && $_GET['sectiontype']=='citymaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CITY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
$editstateId=clean($editresult['stateId']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> City </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">State<span class="redmind"></span></div>
	<select id="stateId" name="stateId" class="gridfield validate" displayname="State" autocomplete="off" onchange="selectcity();" >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_STATE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editstateId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']);?></option>
<?php } ?>
</select>
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo stripslashes($name); ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_citymaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
if($_GET['action']=='addedit_phonetype' && $_GET['sectiontype']=='phonetype'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_PHONE_TYPE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Phone Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_phonetype" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
if($_GET['action']=='addedit_emailtype' && $_GET['sectiontype']=='emailtype'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_EMAIL_TYPE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Email Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_emailtype" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_attachmenttype' && $_GET['sectiontype']=='attachmenttype'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_ATTACHMENT_TYPE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Attachment Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_attachmenttype" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_suppliertype' && $_GET['sectiontype']=='suppliertype'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_TYPE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Supplier Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_suppliertype" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
if($_GET['action']=='addedit_querydestination' && $_GET['sectiontype']=='querydestination'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_DESTINATION_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Destination</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Photo</div>
	<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_querydestination" /> 
 
 <input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['destinationImage']; ?>" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_hotelcategory' && $_GET['sectiontype']=='hotelcategory'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_HOTEL_CATEGORY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Hotel Category </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_hotelcategory" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_tourtype' && $_GET['sectiontype']=='tourtype'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_TOUR_TYPE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Tour Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_tourtype" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_amenities' && $_GET['sectiontype']=='amenities'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_AMENITIES_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Amenities </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_amenities" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_roomtype' && $_GET['sectiontype']=='roomtype'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_ROOM_TYPE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Room Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_roomtype" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php } 
if($_GET['action']=='addedit_currencymaster' && $_GET['sectiontype']=='currencymaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_QUERY_CURRENCY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Currency Master </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_currencymaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php } 
if($_GET['action']=='addedit_mealplan' && $_GET['sectiontype']=='mealplan'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_MEAL_PLAN_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Meal Plan </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_mealplan" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_vehiclemaster' && $_GET['sectiontype']=='vehiclemaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_VEHICLE_MASTER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 $maxpax=clean($editresult['maxpax']);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Vehicle</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Max Pax <span class="redmind"></span></div>
	<input name="maxpax" type="text" class="gridfield validate" id="maxpax" displayname="Pax Pax" value="<?php echo $maxpax; ?>" maxlength="3" onkeyup="numericFilter(this);" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_vehiclemaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_sightseeingmaster' && $_GET['sectiontype']=='sightseeingmaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SIGHTSEEING_MASTER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);    
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Sightseeing Name</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
	
 <div class="griddiv">
<label>
	
	
	
	<div class="gridlable">Destination  <span class="redmind"></span></div>
	<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
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
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$destinationId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
 	<label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_sightseeingmaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_transfermaster' && $_GET['sectiontype']=='transfermaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_TRANSFER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);    
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Transfer Name</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv">
 	<label>
	
	
	
	<div class="gridlable">Destination  <span class="redmind"></span></div>
	<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
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
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$destinationId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
 	<label>
 	<label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_transfermaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	
	
	
	
if($_GET['action']=='addedit_transfercategory' && $_GET['sectiontype']=='transfercategory'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_TRANSFER_CATEGORY_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);    
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Transfer Category</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv">
 	<label>
	
	
	
	<div class="gridlable">Destination  <span class="redmind"></span></div>
	<select id="destinationId" name="destinationId" class="gridfield validate" displayname="Destination" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
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
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$destinationId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select></label>
 	<label>
 	<label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_transfercategory" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	?>
	
	
	
	
	<?php if($_GET['action']=='mastersdelete'){ 

		$name;
		if ($_REQUEST['name']=='vehiclebrandmaster') {
			$name='Vehicle Brand Master';
		}else{
			$name=$_REQUEST['name'];
		}

		?>


	?>
<div class="delbg"><img src="images/Remove-64.png" /></div>
	<div class="contentclass">
<h1 style="padding:15px 0px !important;">Are you sure you want to Deactivate selected <?php echo $name; ?>?</h1> 
 <div id="buttonsbox">
 <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="addnewuserbtn" type="button" class="redmbutton2" id="addnewuserbtn" value="Deactivate" onClick="$('#listform').attr('method','post');$('#listform').attr('target','actoinfrm');$('#listform').attr('action','masters_frmaction.php');submitfieldfrm('listform');"  /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="alertspopupopenClose();" /></td>
      </tr>
   </table>
</div>
	</div>
	
	<?php } 
	
	 
	
	
	
	
	
if($_GET['action']=='addedit_extraquotation' && $_GET['sectiontype']=='extraquotation'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_EXTRA_QUOTATION_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);    
$adultCost=clean($editresult['adultCost']);    
$childCost=clean($editresult['childCost']);    
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Extra Quotation</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Adult Cost</div>
	<input name="adultCost" type="number" class="gridfield" id="adultCost" displayname="Adult Cost" value="<?php echo $adultCost; ?>" maxlength="12" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Child Cost</div>
	<input name="childCost" type="number" class="gridfield" id="childCost" displayname="Child Cost" value="<?php echo $childCost; ?>" maxlength="12" />
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_extraquotation" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
if($_GET['action']=='addeditnewextraquotation' && $_GET['sectiontype']=='extraquotation' && $_GET['queryId']!=''){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_EXTRA_QUOTATION_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);    
$adultCost=clean($editresult['adultCost']);    
$childCost=clean($editresult['childCost']);
$packageCost=clean($editresult['childCost']);     
}
?>
<style>
.addeditpagebox .griddiv .gridlable { 
    width: 100%;
}
.newtowrobox .griddiv{    width: 23% !important;
    display: inline-block;
    margin: 8px;}
</style>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Extra Quotation</h1>
  <div id="contentbox" class="addeditpagebox newtowrobox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Adult Cost</div>
	<input name="adultCost" type="number" class="gridfield" id="adultCost" displayname="Adult Cost" value="<?php echo $adultCost; ?>" maxlength="12" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Child Cost</div>
	<input name="childCost" type="number" class="gridfield" id="childCost" displayname="Child Cost" value="<?php echo $childCost; ?>" maxlength="12" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Package Cost</div>
	<input name="packageCost" type="number" class="gridfield" id="packageCost" displayname="Package Cost" value="<?php echo $packageCost; ?>" maxlength="12" />
	</label>
	</div>
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_extraquotation" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	
	
	
	
	
if($_GET['action']=='currencyconversion' && $_GET['sectiontype']=='currencyconversion'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CURRENCY_CONVERSION_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
  
$currencyFrom=clean($editresult['currencyFrom']);    
$currencyTo=clean($editresult['currencyTo']);    
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Currency Conversion</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Currency From<span class="redmind"></span></div>
	<select id="currencyFrom" name="currencyFrom" class="gridfield validate" displayname="Currency From" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyFrom){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Currency To<span class="redmind"></span></div>
	<select id="currencyTo" name="currencyTo" class="gridfield validate" displayname="Currency To" autocomplete="off"  onchange="selectOpsPersonfunction();"  >
	 <option value="">Select</option>

 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' deletestatus=0 and status=1 order by name asc';  
$rs=GetPageRecord($select,_QUERY_CURRENCY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$currencyTo){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Conversion Value<span class="redmind"></span></div>
	<input name="currencyValue" type="number" class="gridfield" id="currencyValue" displayname="Conversion Value" value="<?php echo $editresult['currencyValue']; ?>" maxlength="12" />
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="currencyconversion" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	
	
	
	
	
	
	
	
	
	
	if($_GET['action']=='addedit_packagetheme' && $_GET['sectiontype']=='packagetheme'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_PACKAGE_THEME_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Pacakege Theme </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_packagetheme" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	
	
	
	
	
	
	if($_GET['action']=='addedit_inclusion' && $_GET['sectiontype']=='inclusion'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_PACKAGE_INCLUSION_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Inclusion </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_inclusion" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
if($_GET['action']=='addedit_packagehotelmaster' ){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_HOTEL_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Hotel</h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="hotelName" type="text" class="gridfield validate" id="hotelName" displayname="Name" value="<?php echo $editresult['hotelName']; ?>" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Destination<span class="redmind"></span></div>
	<select id="hotelCity" name="hotelCity" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['name']); ?>" <?php if($resListing['name']==$editresult['hotelCity']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Country<span class="redmind"></span></div>
	<select id="hotelCountry" name="hotelCountry" class="gridfield validate" displayname="Country" autocomplete="off"   >
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
<option value="<?php echo ($resListing['name']); ?>" <?php if($resListing['name']==$editresult['hotelCountry']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Address</div>
	<input name="hotelAddress" type="text" class="gridfield" id="hotelAddress"  value="<?php echo $editresult['hotelAddress']; ?>" />
	</label>
	</div>
	
 
 	<div class="griddiv"><label>
	<div class="gridlable">Category</div>
	<input name="hotelCategory" type="text" class="gridfield validate" id="hotelCategory" value="<?php echo $editresult['hotelCategory']; ?>" maxlength="1" displayname="Category" />
	 
	</label>
	</div>
 	<div class="griddiv"><label>

	<div class="gridlable">Photo</div>
	<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="0" <?php if($editresult['status']==0){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Supplier</div>
	<select id="supplier" name="supplier" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['supplier']==1){ ?> selected="selected"<?php } ?>>Yes</option>
	 <option value="0" <?php if($editresult['supplier']==0){ ?> selected="selected"<?php } ?>>No</option>
</select>
	</label>
	</div>
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_packagehotelmaster" />
 <input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['hotelImage']; ?>" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	if($_GET['action']=='addedit_packagesightseeingmaster' ){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Sightseeing </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="sightseeingName" type="text" class="gridfield validate" id="sightseeingName" displayname="Name" value="<?php echo strip($editresult['sightseeingName']); ?>" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Destination<span class="redmind"></span></div>
	<select id="sightseeingCity" name="sightseeingCity" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['name']); ?>" <?php if($resListing['name']==$editresult['sightseeingCity']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 
	
	<div class="griddiv"><label>
	<div class="gridlable">Detail</div>
	<textarea name="sightseeingDetail" rows="5" class="gridfield" id="sightseeingDetail"><?php echo strip($editresult['sightseeingDetail']); ?></textarea>
	</label>
	</div>
	
 
 	<div class="griddiv"><label>
	<div class="gridlable">Photo</div>
	<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="0" <?php if($editresult['status']==0){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
 	
<div class="griddiv"><label>
	<div class="gridlable">Type</div>
	<select  name="sightseeingType" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['sightseeingType']==1){ ?> selected="selected"<?php } ?>>SIC</option>
	 <option value="2" <?php if($editresult['sightseeingType']==2){ ?> selected="selected"<?php } ?>>PRIVATE</option>
</select>
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_packagesightseeingmaster" />
 <input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['sightseeingImage']; ?>" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	
	
	
	if($_GET['action']=='addedit_packagetransfermaster' ){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_TRANSFER_MASTER,$where1); 
$editresult=mysqli_fetch_array($rs1);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Transfer </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="transferName" type="text" class="gridfield validate" id="transferName" displayname="Name" value="<?php echo strip($editresult['transferName']); ?>" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Destination<span class="redmind"></span></div>
	<select id="transferCity" name="transferCity" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['name']); ?>" <?php if($resListing['name']==$editresult['transferCity']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 
	
	<div class="griddiv"><label>
	<div class="gridlable">Detail</div>
	<textarea name="transferDetail" rows="5" class="gridfield" id="transferDetail"><?php echo strip($editresult['transferDetail']); ?></textarea>
	</label>
	</div>
	
 
 	
 	<div class="griddiv"><label>
	<div class="gridlable">Photo</div>
	<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="0" <?php if($editresult['status']==0){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Type</div>
	<select  name="transferType" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['transferType']==1){ ?> selected="selected"<?php } ?>>SIC</option>
	 <option value="2" <?php if($editresult['transferType']==2){ ?> selected="selected"<?php } ?>>PRIVATE</option>
</select>
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_packagetransfermaster" />
 <input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['transferImage']; ?>" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	
	
	
	if($_GET['action']=='addedit_packageairlinemaster' ){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_PACKAGE_BUILDER_AIRLINES_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Airline </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="flightName" type="text" class="gridfield validate" id="flightName" displayname="Name" value="<?php echo strip($editresult['flightName']); ?>" />
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Destination<span class="redmind"></span></div>
	<select id="flightCity" name="flightCity" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['name']); ?>" <?php if($resListing['name']==$editresult['flightCity']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 
	
	<div class="griddiv"><label>
	<div class="gridlable">Flight&nbsp;Number</div>
	<input name="flightNo"  class="gridfield" id="flightNo" value="<?php echo strip($editresult['flightNo']); ?>" />
	</label>
	</div>
	
 
 	
 	<div class="griddiv"><label>
	<div class="gridlable">Photo</div>
	<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="0" <?php if($editresult['status']==0){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_packageairlinemaster" />
 <input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['flightImage']; ?>" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	 ?>
	
	
	
	
	
	
<?php 	
	if($_GET['action']=='addeditpackagesupplier_packagehotelmaster' ){ 
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; }?> Hotel Suppliers </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Supplier Name<span class="redmind"></span></div>
	<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Hotel Supplier" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
 if($_GET['hotelid']!=''){
$hotelid=clean($_GET['hotelid']);}
$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);
$mainwhere='';
$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
$assignto=' and	companyTypeId=1';
 
   
  
  
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
}
 
 
 
$where='where '.$wheresearch.' and name!="" '.$assignto.' and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];
/*$sql5="select * from ad_courses ";
$res5 = mysqli_query (db(),$sql5);
$countRoom = $num5=mysqli_num_rows($res5); */
?>
<option value="<?php echo strip($resultlists['id']); ?>" ><?php echo strip($resultlists['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 
 <input name="hotelId" type="hidden" id="hotelId" value="<?php echo $hotelid; ?>" />
 <input name="action" type="hidden" id="action" value="addeditpackagesupplier_packagehotelmaster" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	if($_GET['action']=='addeditpackagesupplier_packagesightseeingmaster' ){ 
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; }?> Sightseeing Suppliers </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Supplier Name<span class="redmind"></span></div>
	<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Sightseeing Suppliers" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
 if($_GET['sightseeingid']!=''){
$sightseeingid=clean($_GET['sightseeingid']);}
$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);
$mainwhere='';
$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
//$assignto=' and	companyTypeId=1';
 
   
  
  
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
}
 
 
 
$where='where '.$wheresearch.' and name!="" '.$assignto.' and sightseeingType=11 and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];
/*$sql5="select * from ad_courses ";
$res5 = mysqli_query (db(),$sql5);
$countRoom = $num5=mysqli_num_rows($res5); */
?>
<option value="<?php echo strip($resultlists['id']); ?>" ><?php echo strip($resultlists['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 
 <input name="sightseeingid" type="hidden" id="sightseeingid" value="<?php echo $sightseeingid; ?>" />
 <input name="action" type="hidden" id="action" value="addeditpackagesupplier_packagesightseeingmaster" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	if($_GET['action']=='addeditpackagesupplier_packagetransfermaster' ){ 
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; }?> Transfer Suppliers </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Supplier Name<span class="redmind"></span></div>
	<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Sightseeing Suppliers" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
 if($_GET['transferid']!=''){
$transferid=clean($_GET['transferid']);}
$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);
$mainwhere='';
$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
//$assignto=' and	companyTypeId=1';
 
   
  
  
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
}
 
 
 
$where='where '.$wheresearch.' and name!="" '.$assignto.' and transferType=10 and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];
/*$sql5="select * from ad_courses ";
$res5 = mysqli_query (db(),$sql5);
$countRoom = $num5=mysqli_num_rows($res5); */
?>
<option value="<?php echo strip($resultlists['id']); ?>" ><?php echo strip($resultlists['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 
 <input name="transferid" type="hidden" id="transferid" value="<?php echo $transferid; ?>" />
 <input name="action" type="hidden" id="action" value="addeditpackagesupplier_packagetransfermaster" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	if($_GET['action']=='addedit_certificatelogomaster' ){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CERTIFICATE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Certificate Logo </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 
	
	<div class="griddiv"><label>
	<div class="gridlable">Name</div>
	<input name="name"  class="gridfield" id="name" value="<?php echo strip($editresult['name']); ?>" />
	</label>
	</div>
	
 
 	
 	<div class="griddiv"><label>
	<div class="gridlable">Photo</div>
	<input name="hotelImage" type="file" class="gridfield" id="hotelImage"/>
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="0" <?php if($editresult['status']==0){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_certificatelogomaster" />
 <input name="hotelImage2" type="hidden" id="hotelImage2" value="<?php echo $editresult['logo']; ?>" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
if($_GET['action']=='addedit_cruisecompanymaster' && $_GET['sectiontype']=='cruisecompanymaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CRUISE_COMPANY_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Cruise Company </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_cruisecompanymaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	
 
	
	
	
	
	
	
	
	
	
	
	
if($_GET['action']=='addedit_cruisetypemaster' && $_GET['sectiontype']=='cruisetypemaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CRUISE_TYPE_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
$companyId=clean($editresult['companyId']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Cruise Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<select id="companyId" name="companyId" class="gridfield validate" displayname="Company Name" autocomplete="off"   >
	 <option value="0">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_CRUISE_COMPANY_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['id']); ?>" <?php if($resListing['name']==$companyId){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_cruisetypemaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	
	
	
	
	
	
	
	
if($_GET['action']=='addedit_cabintypemaster' && $_GET['sectiontype']=='cabintypemaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CABIN_TYPE_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Cabin Type </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_cabintypemaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	
 
	
	
	
	
	
	
	
	if($_GET['action']=='addedit_cabincategorymaster' && $_GET['sectiontype']=='cabincategorymaster'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CABIN_CATEGORY_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$name=clean($editresult['name']);   
 
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Cabin Category </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" displayname="Name" value="<?php echo $name; ?>" maxlength="100" />
	</label>
	</div>
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_cabincategorymaster" /> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	
 
	
	
	
	
	
	
	
	
	
	
			
if($_GET['action']=='addedit_cruisemaster' ){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_CRUISE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Cruise </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2" valign="top"><div class="griddiv"><label>
	<div class="gridlable">Company<span class="redmind"></span></div>
	<select id="cruiseCompany" onchange="loadcruisetypefun();" name="cruiseCompany" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_CRUISE_COMPANY_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['id']); ?>" <?php if($resListing['id']==$editresult['cruiseCompany']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Cruise Type <span class="redmind"></span></div>
	<select id="cruiseType" name="cruiseType" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_CRUISE_TYPE_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['id']); ?>" <?php if($resListing['id']==$editresult['cruiseType']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
<script>
function loadcruisetypefun(){
var companyId = $('#cruiseCompany').val();
$('#cruiseType').load('loadcruiseType.php?companyId='+companyId);
}
</script>
	</label>
	</div>
 <div class="griddiv"><label>
	<div class="gridlable">Name<span class="redmind"></span></div>
	<input name="cruiseName" type="text" class="gridfield validate" id="cruiseName" displayname="Name" value="<?php echo $editresult['cruiseName']; ?>" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Cabin Category <span class="redmind"></span></div>
	<select id="cabinCategory" name="cabinCategory" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_CABIN_CATEGORY_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['id']); ?>" <?php if($resListing['id']==$editresult['cabinCategory']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Cabin Type <span class="redmind"></span></div>
	<select id="cabinType" name="cabinType" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_CABIN_TYPE_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['id']); ?>" <?php if($resListing['id']==$editresult['cabinType']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Price<span class="redmind"></span></div>
	<input name="price" type="text" class="gridfield validate" id="price" displayname="Price" value="<?php echo $editresult['price']; ?>" />
	</label>
	</div>
	</td>
    <td width="50%" valign="top">
	
	<div class="griddiv"><label>
	<div class="gridlable">Cabin Number</div>
	<input name="cabinNumber" type="text" class="gridfield" id="cabinNumber"  value="<?php echo $editresult['cabinNumber']; ?>" />
	</label>
	</div>
	
	
	
	
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Destination<span class="redmind"></span></div>
	<select id="destination" name="destination" class="gridfield validate" displayname="city" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' 1 order by name asc';  
$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo ($resListing['name']); ?>" <?php if($resListing['name']==$editresult['destination']){ ?>selected="selected"<?php } ?>><?php echo ($resListing['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
	
 
 	 
	
	<div class="griddiv"><label>
	<div class="gridlable">Duration<span class="redmind"></span></div>
	<select id="duration" name="duration" class="gridfield validate" displayname="city" autocomplete="off"   >
	
	 <option value="0">Select</option>
	 <?php
	 $sum = 0;
for($i = 1; $i<=30; $i++) {  
?>
	 <option value="<?php echo $i ; ?>" <?php if($editresult['duration']==$i){ ?>selected="selected"<?php } ?>><?php echo $i ; ?> Nights</option>
	 <?php } ?>
  
</select>
	</label>
	</div>
	
	
 	<div class="griddiv"><label>
	<div class="gridlable">Photo</div>
	<input name="cruiseImage" type="file" class="gridfield" id="cruiseImage"/>
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="0" <?php if($editresult['status']==0){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	</td>
  </tr>
</table>
	
	
	
	
 
  
	 
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="action" type="hidden" id="action" value="addedit_cruisemaster" />
 <input name="cruiseImage2" type="hidden" id="cruiseImage2" value="<?php echo $editresult['cruiseImage']; ?>" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	if($_GET['action']=='addeditpackageCruisesupplier_cruisemaster' ){  
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; }?> Cruise Suppliers </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Supplier Name<span class="redmind"></span></div>
	<select id="supplierId" name="supplierId" class="gridfield validate" displayname="Sightseeing Suppliers" autocomplete="off"   >
	 <option value="">Select</option>
 <?php 
 if($_GET['cruiseid']!=''){
$cruiseid=clean($_GET['cruiseid']);}
$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);
$mainwhere='';
$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
  
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
} 
 
$where='where '.$wheresearch.' and name!="" '.$assignto.' and cruiseType=12 and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];
/*$sql5="select * from ad_courses ";
$res5 = mysqli_query (db(),$sql5);
$countRoom = $num5=mysqli_num_rows($res5); */
?>
<option value="<?php echo strip($resultlists['id']); ?>" ><?php echo strip($resultlists['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
 
 <input name="cruiseid" type="hidden" id="cruiseid" value="<?php echo $cruiseid; ?>" />
 <input name="action" type="hidden" id="action" value="addeditpackageCruisesupplier_cruisemaster" />
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	
	
	
	
	
	
	
	
	
	if($_GET['action']=='addCruiseSupplierRate' ){ 
	
 $cruiseid = decode($_REQUEST['cruiseid']);
 $supplierId = decode($_REQUEST['supplierId']);
$select='';
$where='';
$rs='';  
$select='*'; 
$where=' cruiseid="'.$cruiseid.'" and supplierId="'.$supplierId.'" order by id asc'; 
$rs=GetPageRecord($select,_PACKAGE_CRUISE_RATE_,$where); 
 $count = mysqli_num_rows($rs);
$editresult=mysqli_fetch_array($rs);
?>
<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($count > 0){ echo 'Edit Price'; }else{ echo 'Add Price'; } ?> Cruise Suppliers </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
	<div class="griddiv">
		<label>
		<div class="gridlable">From Date<span class="redmind"></span></div>
		<input name="fromDate" type="text" class="gridfield validate" id="fromDate" displayname="From Date" value="<?php if($editresult['fromDate']!='01-01-1970' && $editresult['fromDate']!='' && $editresult['fromDate']!='0'){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } ?>" />
		</label>
	</div>
	<div class="griddiv">
		<label>
		<div class="gridlable">To Date<span class="redmind"></span></div>
		<input name="toDate" type="text" class="gridfield validate" id="toDate" displayname="To Date" value="<?php if($editresult['toDate']!='01-01-1970' && $editresult['toDate']!='' && $editresult['toDate']!='0'){ echo date('d-m-Y',strtotime($editresult['toDate'])); } ?>" />
		</label>
	</div>
	<div class="griddiv">
		<label>
		<div class="gridlable">Price<span class="redmind"></span></div>
		<input name="price" type="text" class="gridfield validate" id="price" displayname="Price" value="<?php echo strip($editresult['price']); ?>" />
		</label>
	</div>
	
 <input name="cruiseid" type="hidden" id="cruiseid" value="<?php echo $cruiseid; ?>" />
 <input name="supplierId" type="hidden" id="supplierId" value="<?php echo $supplierId; ?>" />
 <input name="action" type="hidden" id="action" value="addCruiseSupplierRate" />
</form>
<script>
 $(document).ready(function() {   
$('#toDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 
$('#fromDate').Zebra_DatePicker({
  format: 'd-m-Y',  
}); 
  });
</script>
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	<?php }
	
		/*if($_GET['action']=='cms_gallery' ){ 
	
 $cruiseid = decode($_REQUEST['cruiseid']);
 $supplierId = decode($_REQUEST['supplierId']);
$select='';
$where='';
$rs='';  
$select='*'; 
$where=' cruiseid="'.$cruiseid.'" and supplierId="'.$supplierId.'" order by id asc'; 
$rs=GetPageRecord($select,_PACKAGE_CRUISE_RATE_,$where); 
 $count = mysqli_num_rows($rs);
$editresult=mysqli_fetch_array($rs);
?>
<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($count > 0){ echo 'Edit Price'; }else{ echo 'Add Price'; } ?> Cruise Suppliers </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
	<div class="griddiv">
		<label>
		<div class="gridlable">From Date<span class="redmind"></span></div>
		<input name="fromDate" type="text" class="gridfield validate" id="fromDate" displayname="From Date" value="<?php if($editresult['fromDate']!='01-01-1970' && $editresult['fromDate']!='' && $editresult['fromDate']!='0'){ echo date('d-m-Y',strtotime($editresult['fromDate'])); } ?>" />
		</label>
	</div>
	<div class="griddiv">
		<label>
		<div class="gridlable">To Date<span class="redmind"></span></div>
		<input name="toDate" type="text" class="gridfield validate" id="toDate" displayname="To Date" value="<?php if($editresult['toDate']!='01-01-1970' && $editresult['toDate']!='' && $editresult['toDate']!='0'){ echo date('d-m-Y',strtotime($editresult['toDate'])); } ?>" />
		</label>
	</div>
	<div class="griddiv">
		<label>
		<div class="gridlable">Price<span class="redmind"></span></div>
		<input name="price" type="text" class="gridfield validate" id="price" displayname="Price" value="<?php echo strip($editresult['price']); ?>" />
		</label>
	</div>
	
 <input name="cruiseid" type="hidden" id="cruiseid" value="<?php echo $cruiseid; ?>" />
 <input name="supplierId" type="hidden" id="supplierId" value="<?php echo $supplierId; ?>" />
 <input name="action" type="hidden" id="action" value="addCruiseSupplierRate" />
</form>
<script>
 $(document).ready(function() {   
$('#toDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 
$('#fromDate').Zebra_DatePicker({
  format: 'd-m-Y',  
}); 
  });
</script>
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	<?php }*/
	
	if($_GET['action']=='addedit_cms' && $_GET['page']=='gallery'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$title=clean($editresult['title']);   
$feature_img=clean($editresult['feature_img']);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Photo Gallery </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Gallery Title<span class="redmind"></span></div>
	<input name="title" type="text" class="gridfield validate" id="title" displayname="Gallery Title" value="<?php echo $title; ?>" maxlength="100" />
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Destination as(Tags)<span class="redmind"></span></div>
	<select id="destination" name="destination[]" class="gridfield" data-placeholder="Select Gallery Tags" multiple >
	 <option value="">--Choose Option--</option>
<?php 
                $tagsQuery=mysqli_query (db(),"select * from "._DESTINATION_MASTER_." where status='1' order by name asc");
                while($tagsData=mysqli_fetch_array($tagsQuery)){ 
                $isSelected_destination = array_map('trim', explode(",", $editresult['subcategory']));
                ?>
<option value="<?php echo $tagsData['id']; ?>" <?php if(in_array($tagsData['id'],$isSelected_destination)) { ?> selected="selected" <?php } ?>>
                  <?php echo $tagsData['name']; ?></option>
<?php } ?>
</select>
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Package Theme<span class="redmind"></span></div>
	<select id="package_theme" name="package_theme[]" class="gridfield"data-placeholder="Select Gallery Tags" multiple >
	 <option value="0">Select Themes</option>
<?php 
                  $package_themeSql=mysqli_query (db(),"select * from "._PACKAGE_THEME_MASTER_." where status='1' order by name asc");
                  while($package_themeData=mysqli_fetch_array($package_themeSql)){ 
                  $isSelected_theme = array_map('trim', explode(",", $editresult['category'])); 
                  ?>
<option value="<?php echo $package_themeData['id']; ?>" <?php if(in_array($package_themeData['id'],$isSelected_theme)) { ?> selected="selected" <?php } ?>>
                  <?php echo $package_themeData['name']; ?></option>
<?php } ?>
</select>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Gallery Preview Image</div>
	<?php if($feature_img==''){?><input name="file1" type="file" class="gridfield validate"  displayname="Image"  id="file1"/><?php }
	else {?><input name="file1" type="file" class="gridfield" id="file1"/><?php }?>
	<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
	</label>
	</div>

<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
 <input name="action" type="hidden" id="action" value="cms_add_gallery" />
 	  <script type="text/javascript">
    $('#destination').select2();
    $('#package_theme').select2();
  </script> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	

if($_GET['action']=='addedit_cms' && $_GET['page']=='add-images'){ 

$cid=clean($_GET['cid']);
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$title=clean($editresult['title']);   
$feature_img=clean($editresult['feature_img']);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Photo Gallery </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Image Title<span class="redmind"></span></div>
	<input name="title" type="text" class="gridfield validate" id="title" displayname="Gallery Title" value="<?php echo $title; ?>" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Gallery Preview Image</div>
	<?php if($feature_img==''){?><input name="file1" type="file" class="gridfield validate"  displayname="Image"  id="file1"/><?php }
	else {?><input name="file1" type="file" class="gridfield" id="file1"/><?php }?>
	<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
	</label>
	</div>

<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="cid" type="hidden" id="cid" value="<?php echo $cid; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
 <input name="action" type="hidden" id="action" value="cms_add_images" />
 	  <script type="text/javascript">
    $('#destination').select2();
    $('#package_theme').select2();
  </script> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	

	
	if($_GET['action']=='addedit_cms' && $_GET['page']=='blog'){ 
 
if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$title=clean($editresult['title']); 
$description=clean($editresult['description']);  
$feature_img=clean($editresult['feature_img']);
$feature_img2=clean($editresult['image2']);
$home_text=clean($editresult['home_text']);
$designation=clean($editresult['designation']);
$meta_title=clean($editresult['meta_title']);
$meta_description=clean($editresult['meta_description']);
$meta_keyword=clean($editresult['meta_keyword']);
$post_date=clean($editresult['post_date']);
}
?>

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
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Blog </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">

<div class="griddiv"><label>
	<div class="gridlable">Post Date<span class="redmind"></span></div>
	<input name="post_date" type="text" class="gridfield calfieldicon" id="post_date" value="<?php if($post_date!=""){ echo date("d-m-Y", strtotime($post_date)); } else { echo date('d-m-Y'); ?><?php } ?>" maxlength="100" />
	</label>
	</div>
	
	<script>
 $(document).ready(function() {   
$('#post_date').Zebra_DatePicker({ 
  format: 'd-m-Y',  
}); 
  });
</script>
<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
	
 <div class="griddiv"><label>
	<div class="gridlable">Title<span class="redmind"></span></div>
	<input name="title" type="text" class="gridfield validate" id="title" displayname="Title" value="<?php echo $title; ?>" maxlength="100" />
	</label>
	</div>
	
	
	<div class="griddiv"><label>
	<div class="gridlable">Description<span class="redmind"></span></div>
	<textarea name="description" id="description" style="width:98%;" class="gridfield" ><?php  echo stripslashes($description); ?></textarea>
	</label>
	</div>
	

	<div class="griddiv"><label>
	<div class="gridlable">Image</div>
	<input name="file1" type="file" class="gridfield" id="file1"/>
	<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
	</label>
	</div>

<div class="griddiv"><label>
	<div class="gridlable">Author Name<span class="redmind"></span></div>
	<input name="home_text" type="text" class="gridfield" id="home_text" value="<?php echo $home_text; ?>" maxlength="100" />
	</label>
	</div>
	
<div class="griddiv"><label>
	<div class="gridlable">Author Designation<span class="redmind"></span></div>
	<input name="designation" type="text" class="gridfield" id="designation" value="<?php echo $designation; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Author Photo</div>
	<input name="file2" type="file" class="gridfield" id="file2"/>
	<input name="feature_img2" type="hidden" class="grybutton" id="feature_img2" value="<?php echo $feature_img2; ?>"/>
	</label>
	</div>

<div class="griddiv"><label>
	<div class="gridlable">Meta Title<span class="redmind"></span></div>
	<input name="meta_title" type="text" class="gridfield" id="meta_title" value="<?php echo $meta_title; ?>" maxlength="100" />
	</label>
	</div>

	<div class="griddiv"><label>
	<div class="gridlable">Meta Description<span class="redmind"></span></div>
	<textarea name="meta_description" id="meta_description" style="width:98%;" class="gridfield" ><?php  echo stripslashes($meta_description); ?></textarea>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Meta Keywords<span class="redmind"></span></div>
	<textarea name="meta_keyword" id="meta_keyword" style="width:98%;" class="gridfield" ><?php  echo stripslashes($meta_keyword); ?></textarea>
	</label>
	</div>
	
<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
 <input name="action" type="hidden" id="action" value="cms_add_blog" />
 	  <script type="text/javascript">
    $('#destination').select2();
    $('#package_theme').select2();
  </script> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php 
}	

	if($_GET['action']=='addedit_cms' && $_GET['page']=='banner'){ 

if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$title=clean($editresult['title']);  
$description=clean($editresult['description']);  
$feature_img=clean($editresult['feature_img']);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Banner </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Banner Title<span class="redmind"></span></div>
	<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Destination Worldwide<span class="redmind"></span></div>
	<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Banner Image</div>
	<input name="file1" type="file" class="gridfield" id="file1"/>
	<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
	</label>
	</div>

<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
 <input name="action" type="hidden" id="action" value="cms_add_banner" />
 	  <script type="text/javascript">
    $('#destination').select2();
    $('#package_theme').select2();
  </script> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	
	
	if($_GET['action']=='addedit_cms' && $_GET['page']=='user-reviews'){ 

if($_GET['id']!=''){
$id=clean($_GET['id']);
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$title=clean($editresult['title']);  
$description=clean($editresult['title']);  
$feature_img=clean($editresult['feature_img']);
}
?>
<div class="contentclass">
<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?> Banner </h1>
  <div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
<form action="masters_frmaction.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
 <div class="griddiv"><label>
	<div class="gridlable">Banner Title<span class="redmind"></span></div>
	<input name="title" type="text" class="gridfield validate" id="title" displayname="Name" value="<?php echo $title; ?>" maxlength="100" />
	</label>
	</div>
<div class="griddiv"><label>
	<div class="gridlable">Destination Worldwide<span class="redmind"></span></div>
	<textarea name="description" rows="3" id="description" style="width:98%;"><?php echo $description; ?></textarea>
	</label>
	</div>
	<div class="griddiv"><label>
	<div class="gridlable">Banner Image</div>
	<input name="file1" type="file" class="gridfield" id="file1"/>
	<input name="feature_img" type="hidden" class="grybutton" id="feature_img" value="<?php echo $feature_img; ?>"/>
	</label>
	</div>

<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield " autocomplete="off"   >
	 <option value="1" <?php if($editresult['status']==1){ ?> selected="selected"<?php } ?>>Active</option>
	 <option value="2" <?php if($editresult['status']==2){ ?> selected="selected"<?php } ?>>Inactive</option>
</select>
	</label>
	</div>
	
 <input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
 <input name="module" type="hidden" id="module" value="<?php echo $_GET['module']; ?>" />
 <input name="action" type="hidden" id="action" value="cms_add_banner" />
 	  <script type="text/javascript">
    $('#destination').select2();
    $('#package_theme').select2();
  </script> 
</form>
  
  
  </div>
  <div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }	

if($_GET['action']=='addedit_vehiclebrandmaster' && $_GET['sectiontype']=='vehiclebrandmaster'){ 
 
		if($_GET['id']!=''){
		$id=clean($_GET['id']);
		$select1='*';  
		$where1='id='.$id.''; 
		$rs1=GetPageRecord($select1,_VEHICLE_BRAND_MASTER_,$where1); 
		$editresult=mysqli_fetch_array($rs1);
		$vehicleType=clean($editresult['vehicleType']);   
		$brandName=clean($editresult['brandName']);   
		$vechileName=clean($editresult['name']); 
		$status=clean($editresult['status']); 
		
		}
		?>
		<div class="contentclass">
		<h1 style="text-align:left;"><?php if($_REQUEST['id']!=''){ echo 'Edit'; } else { echo 'Add'; } ?>
		Vehicle </h1>
		<div id="contentbox" class="addeditpagebox" style="  padding:16px; overflow:auto; text-align:left; margin-bottom:0px; " >
		<form action="masters_frmactionvehicle.php" method="post" enctype="multipart/form-data" name="addmasters" target="actoinfrm" id="addmasters">
		<div class="griddiv"><label>
			<div class="gridlable">Vehicle&nbsp;Type<span class="redmind"></span></div>
			<select id="vehicleType" name="vehicleType" class="gridfield"  autocomplete="off" style="width: 100%;">  
			<?php    
			$rs=GetPageRecord('name,id','vehicleTypeMaster',' 1 order by name asc'); 
			while($resListing=mysqli_fetch_array($rs)){  
			?>
			<option value="<?php echo strip($resListing['id']); ?>" <?php if($vehicleType==strip($resListing['id'])){ ?> selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
			<?php } ?> 
			</select>
			</label>
			</div> 
			<div class="griddiv"><label>
			<div class="gridlable">Brand Name<span class="redmind"></span></div>
			<input name="name" type="text" class="gridfield validate" id="name" displayname="Brand Name" value="<?php echo $vechileName; ?>" maxlength="100" />
			</label>
			</div>
		
		<!--   <div class="griddiv"><label>
			<div class="gridlable">Capacity<span class="redmind"></span></div>
			<input name="capacity" type="text" class="gridfield validate" id="capacity" displayname="Capacity" value="<?php echo $capacity; ?>" maxlength="100" />
			</label>
			</div> --> 
			<script> 
				// function fileValidation() { 
				//     var fileInput =  
				//         document.getElementById('vehicleImage'); 
					
				//     var filePath = fileInput.value; 
				
				//     // Allowing file type 
				//     var allowedExtensions =  
				//             /(\.jpg|\.jpeg|\.png|\.gif)$/i; 
					
				//     if (!allowedExtensions.exec(filePath)) { 
				//         alert('Please Upload Image JPG , JPEG , PNG , GIF'); 
				//         fileInput.value = ''; 
				//         return false; 
				//     }  }
						</script>
			
			
			
			
			<!-- <div class="griddiv"><label>

				<div class="gridlable">Vehicle Image</div>

				<input name="vehicleImage" type="file" class="gridfield" id="vehicleImage" onchange="return fileValidation()"/>

				<input type="hidden" name="vehicleImage2" id="vehicleImage2" value="<?php echo $editresult['image']; ?>" />

				</label>

			</div> -->
			
			<div class="griddiv">
			<label> 
			<div class="gridlable">status</div>
			<select id="status" type="text" class="gridfield" name="status" displayname="Status" autocomplete="off" value="<?php echo $status; ?>"  style="width: 100%;"> 	
			<option value="1" <?php if($status=='1'){ ?>selected="selected"<?php } ?>>Active</option>
			<option value="0" <?php if($status=='0'){ ?>selected="selected"<?php } ?>>In Active</option>
			</select></label>
			</div>
			
			
			
		<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
		<input name="module" type="hidden" id="module" value="<?php echo $_GET['sectiontype']; ?>" />
		<input name="action" type="hidden" id="action" value="addedit_vehiclebrandmaster" /> 
		</form>
		
		
		</div>
		<div id="buttonsbox"  style="text-align:center;">
 <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="    Save    " onclick="formValidation('addmasters','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
      </tr>
   </table>
</div></div>
	 
	
	<?php }
	 ?>	