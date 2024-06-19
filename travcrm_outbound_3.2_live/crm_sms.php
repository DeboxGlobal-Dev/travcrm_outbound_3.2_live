<?php 
$select='*'; 
$where='userId="'.$loginusersuperParentId.'"'; 
$rs=GetPageRecord($select,_SMS_MASTER_,$where); 
$emailsetting=mysqli_fetch_array($rs); 
 

 

?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"> 
      <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>SMS Setting </td>
    </tr>
</table>
	  </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($profileId!=1){ ?><td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td><?php } ?>
		
		 
		
		
         <td style="padding-right:20px;">&nbsp; </td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">
<div class="addeditpagebox">
 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
 
   <input name="action" type="hidden" id="action" value="<?php if(clean($_GET['id'])!=''){ echo 'editrole'; } else {  echo 'addrole'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <input name="roleId" type="hidden" id="roleId" value="<?php echo $relatedroleidname['id']; ?>" />
  
  
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>SMS Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv">
	<label>
	<div class="gridlable"> SMS API URL <span class="redmind"></span></div>
	<input name="url" type="text" class="gridfield validate" id="url" value="<?php echo $emailsetting['url']; ?>" maxlength="250" displayname="SMS API URL" autocomplete="off" />
	</label>
	</div> 
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Username <span class="redmind"></span></div>
	<input name="user_name" type="text" class="gridfield validate" id="user_name" value="<?php echo $emailsetting['user_name']; ?>" maxlength="60" displayname="Username" autocomplete="off" />
	</label>
	</div>
	
	<div class="griddiv">
	<label>
	<div class="gridlable">Password <span class="redmind"></span></div>
	<input name="password" type="password" class="gridfield validate" id="password" value="<?php echo $emailsetting['password']; ?>" maxlength="30" displayname="Password" autocomplete="off" />
	</label>
	</div>
		<div class="griddiv">
      <label>
      <div class="gridlable">Sender Id  <span class="redmind"></span></div>
      <input name="senderid" type="text" class="gridfield" id="senderid" value="<?php echo $emailsetting['senderid']; ?>" maxlength="230"  autocomplete="off"  displayname="Sender Id" />
      </label>
    </div>
	 
	
	 	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" ></td>
    </tr>
  
  
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
  </tr>
</table>
 

</div>
 <div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><input name="action" type="hidden" id="action" value="smssetting" />
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
         <td style="padding-right:20px;">&nbsp; </td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>
 
</div>
<script>  
comtabopenclose('linkbox','op1');
</script>
