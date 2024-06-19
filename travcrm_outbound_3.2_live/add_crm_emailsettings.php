<?php 
if($_REQUEST['id']!=''){
  $select='*'; 
  $where='id="'.decode($_REQUEST['id']).'"'; 
  $rs=GetPageRecord($select,_EMAIL_SETTING_MASTER_,$where); 
  $emailsetting=mysqli_fetch_array($rs); 
}
if($addpermission!=1 && $emailsetting['id']==''){
  header('location:'.$fullurl.'');
}
if($editpermission!=1 && $emailsetting['id']!=''){
  header('location:'.$fullurl.'');
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>
      <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td>&nbsp;Configure Email</td>
    </tr>
</table>
	<?php } else { ?>
	Configure Email
	<?php } ?>   </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($profileId!=1){ ?><?php if($_REQUEST['del']!=1){ ?><td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td><?php } } ?>
         <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">
<div class="addeditpagebox">
 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <input name="roleId" type="hidden" id="roleId" value="<?php echo $relatedroleidname['id']; ?>" />
  
  
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Email Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
      <div class="griddiv">
        <label>
          <div class="gridlable">From Name <span class="redmind"></span></div>
          <input name="from_name" type="text" class="gridfield validate" id="from_name" value="<?php echo $emailsetting['from_name']; ?>" maxlength="60" displayname="From Name" autocomplete="off" />
        </label>
      </div>

      <div class="griddiv">
        <label>
          <div class="gridlable">Email <span class="redmind"></span></div>
          <input name="email" type="text" class="gridfield validate" id="email" value="<?php echo $emailsetting['email']; ?>" maxlength="60" displayname="Email" autocomplete="off" />
        </label>
      </div>

      <div class="griddiv">
        <label>
          <div class="gridlable">Password <span class="redmind"></span></div>
          <input name="password" type="password" class="gridfield validate" id="password" value="<?php echo ($emailsetting['password']); ?>" maxlength="30" displayname="Password" autocomplete="off" />
        </label>
      </div>
      <div class="griddiv">
        <label>
          <div class="gridlable">SMTP Server  <span class="redmind"></span></div>
          <input name="smtp_server" type="text" class="gridfield validate" id="smtp_server" value="<?php echo $emailsetting['smtp_server']; ?>" maxlength="230"  autocomplete="off" displayname="SMTP Server" />
        </label>
      </div>
      <div class="griddiv">
        <label>
          <div class="gridlable">Port  <span class="redmind"></span></div>
          <input name="port" type="text" class="gridfield validate" id="port" value="<?php echo $emailsetting['port']; ?>" maxlength="10"  autocomplete="off"  displayname="Port" />
        </label>
      </div>

      <div class="griddiv">
        <label>
          <div class="gridlable">Security Type  <span class="redmind"></span></div>
          <select id="security_type" name="security_type" class="gridfield validate" displayname="Security Type" autocomplete="off">
            <option value="false" <?php if($emailsetting['security_type']=='false'){ ?>selected="selected"<?php } ?>>None</option>
            <option value="true" <?php if($emailsetting['security_type']=='true'){ ?>selected="selected"<?php } ?>>SSL</option>
          </select>
        </label>
      </div>

      <!--imap_server imap_port imap_security_type imap_filter-->
      
     <div class="griddiv">
        <label>
          <div class="gridlable">IMAP Server  <span class="redmind"></span></div>
          <input name="imap_server" type="text" class="gridfield validate" id="imap_server" value="<?php echo $emailsetting['imap_server']; ?>" maxlength="230"  autocomplete="off" displayname="IMAP Server" />
        </label>
      </div>
      <div class="griddiv">
        <label>
          <div class="gridlable">IMAP Port  <span class="redmind"></span></div>
          <input name="imap_port" type="text" class="gridfield validate" id="imap_port" value="<?php echo $emailsetting['imap_port']; ?>" maxlength="10"  autocomplete="off"  displayname="IMAP Port" />
        </label>
      </div>

      <div class="griddiv">
        <label>
          <div class="gridlable">IMAP Security Type  <span class="redmind"></span></div>
          <select id="imap_security_type" name="imap_security_type" class="gridfield validate" displayname="Security Type" autocomplete="off">
            <option value="notls" <?php if($emailsetting['imap_security_type']=='notls'){ ?>selected="selected"<?php } ?>>None</option>
            <option value="ssl" <?php if($emailsetting['imap_security_type']=='ssl'){ ?>selected="selected"<?php } ?>>SSL</option>
          </select>
        </label>
      </div>
      
      <div class="griddiv">
        <label>
          <div class="gridlable">IMAP Filter</div>
          <input name="imap_filter" type="text" class="gridfield " id="imap_filter" value="<?php echo $emailsetting['imap_filter']; ?>" maxlength="10"  autocomplete="off"  displayname="IMAP Filter" />
        </label>
      </div>

      
      <div class="griddiv">
        <label>
          <!-- <div class="gridlable">Default</div> --><br>
          <input name="isDefault" type="checkbox" style="display: inline-block;" id="isDefault" value="1" <?php if($emailsetting['isDefault']=='1'){ ?>checked="checked"<?php } ?>/>&nbsp;&nbsp;Set Default
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
    <td align="right"><input name="action" type="hidden" id="action" value="emailsetting" />
	<input name="editId" type="hidden" id="editId" value="<?php echo $emailsetting['id']; ?>" />
  <input name="oldps" type="hidden" id="oldps" value="<?php echo $emailsetting['password']; ?>" />
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
         <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
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
