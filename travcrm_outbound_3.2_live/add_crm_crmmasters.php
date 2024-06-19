<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
 $id=clean(decode($_GET['id'])); 
	$select1='*';  
	$where1='id='.$id.''; 
	$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
	$editresult=mysqli_fetch_array($rs1);

	$editComapnyanme=clean($editresult['company']);
	$editEmail=clean($editresult['email']);
	$editPhone=clean($editresult['phone']);
	$editPassword=clean($editresult['password']);
	$editMobile=clean($editresult['mobile']);
	$editStreet=clean($editresult['street']);
	$editCity=clean($editresult['city']);
	$editState=clean($editresult['state']);
	$editZip=clean($editresult['zip']);
	$editCountry=clean($editresult['country']);
	$editNoofusers=clean($editresult['noofusers']);
	$editServerspace=clean($editresult['serverspace']);
	$editExpireDate=$editresult['expiryDate'];
	$editTimeformat=clean($editresult['timeFormat']);
	$editCurrency=clean($editresult['currency']);
	$editTimezone=clean($editresult['timeZone']);


}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> CRM Master</span></div></td>
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

<div id="pagelisterouter">
<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="addcrmmasters" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;"><div class="innerbox"><h2>CRM Account Information</h2></div>
	<div class="griddiv">
	<label><div class="gridlable">Company Name<span class="redmind"></span></div>
	<input name="company" type="text" class="gridfield validate" value="<?php echo $editComapnyanme; ?>" maxlength="100" displayname="Company" autocomplete="off" />
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Email<?php if($_GET['id']==''){ ?><span class="redmind"></span><?php } ?></div>
	<input name="email" type="email"  class="gridfield validate" id="email" value="<?php echo $editEmail; ?>" displayname="Email" autocomplete="off"  <?php if($_GET['id']!=''){ ?>readonly="true"<?php } ?>/>
	</label>
	</div>
	
	 <div class="griddiv"><label>
	<div class="gridlable">Password<?php if($_GET['id']==''){ ?><span class="redmind"></span><?php } ?></div>
	<input name="password" type="password" class="gridfield validate" id="password" value="<?php echo $editPassword; ?>" maxlength="15" displayname="Password" />
	<input name="oldpassword" id="oldpassword" type="hidden" value="<?php echo $editPassword; ?>"/>
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Phone</div>
	<input name="phone" type="text" class="gridfield" id="phone" value="<?php echo $editPhone; ?>" maxlength="15" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Mobile</div>
	<input name="mobile" type="text" class="gridfield" id="mobile" value="<?php echo $editMobile; ?>" maxlength="15" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Street</div>
	<input name="street" type="text" class="gridfield" id="street" value="<?php echo $editStreet; ?>" maxlength="60" />
	</label>
	</div>
	 
	 
	 <div class="griddiv"><label>
	<div class="gridlable">City</div>
	<input name="city" type="text" class="gridfield" id="city" value="<?php echo $editCity; ?>" maxlength="100" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">State</div>
	<input name="state" type="text" class="gridfield" id="state" value="<?php echo $editState; ?>" maxlength="60" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Zip</div>
	<input name="zip" type="text" class="gridfield" id="zip" value="<?php echo $editZip; ?>" maxlength="15" />
	</label>
	</div>
	
	<div class="griddiv"><label>
	<div class="gridlable">Country</div>
	<select id="country" name="country" class="gridfield">
	<option value="">Select</option>
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" order by name'; 
$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where); 
while($country=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($country['id']); ?>" <?php if($editCountry==$country['id']){ ?>selected="selected"<?php } ?>><?php echo strip($country['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	
	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"><div class="innerbox">
      <h2>Users / Account Validity  Information </h2>
    </div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Users Limit <span class="redmind"></span></div>
	<input name="noofusers" type="number" class="gridfield validate" id="noofusers" value="<?php echo $editNoofusers; ?>" maxlength="3" displayname="No of Users" autocomplete="off" />
	</label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Server Space (MB)<span class="redmind"></span></div>
	<input name="serverspace" type="number" class="gridfield validate" id="serverspace" value="<?php echo $editServerspace; ?>" maxlength="5" displayname="Server Space" autocomplete="off" />
	</label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Expiry Date<span class="redmind"></span></div>
	<input name="expirydate" type="text" id="expirydate" class="gridfield calfieldicon validate" displayname="Expiry Date" autocomplete="off" value="<?php if($editExpireDate!=''){ echo date("d-m-Y", strtotime($editExpireDate)); } ?>" /></label>
	</div>
	
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Time Format </div>
	<select id="timeformat" name="timeformat" class="gridfield">
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" order by name'; 
$rs=GetPageRecord($select,_TIMEFORMAT_MASTER_,$where); 
while($timeformat=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($timeformat['id']); ?>" <?php if($timeformat==$editTimeformat['id']){ ?>selected="selected"<?php } ?>><?php echo strip($timeformat['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Currency </div> 
	<select id="currency" name="currency" class="gridfield">
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" order by name'; 
$rs=GetPageRecord($select,_CURRENCY_MASTER_,$where); 
while($currency=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($currency['id']); ?>" <?php if($currency==$editCurrency['id']){ ?>selected="selected"<?php } ?>><?php echo strip($currency['name']); ?></option>
<?php } ?>
</select>
	</label>
	</div>
	<div class="griddiv">
	<label>
	<div class="gridlable">Time Zone </div>
	<select id="timezone" name="timezone" class="gridfield">
 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" order by name'; 
$rs=GetPageRecord($select,_TIMEZONE_MASTER_,$where); 
while($timezone=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($timezone['id']); ?>" <?php if($timezone==$editTimezone['id']){ ?>selected="selected"<?php } ?>><?php echo strip($timezone['name']); ?></option>
<?php } ?>
</select></label>
	</div>
	 </td>
  </tr>
</table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
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
comtabopenclose('linkbox','op4');
</script>
