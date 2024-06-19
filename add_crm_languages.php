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
$rs1=GetPageRecord($select1,'languageMaster',$where1); 
$editresult=mysqli_fetch_array($rs1);
 
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> Language </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
  
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" <?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="addlanguage" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;"><div class="innerbox"><h2> Information</h2>
    </div>
	<div class="griddiv">
	<label><div class="gridlable"> Name<span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" value="<?php echo stripslashes($editresult['name']); ?>" maxlength="100" displayname="Name" autocomplete="off" />
	</label>
	</div>
	 
	<div class="griddiv"><label>
	<div class="gridlable">Status</div>
	<select id="status" name="status" class="gridfield">
	<option value="1" <?php if($editresult['status']=='1'){ ?>selected="selected"<?php } ?>>Active</option> 
	<option value="0" <?php if($editresult['status']=='0'){ ?>selected="selected"<?php } ?>>Inactive</option> 
 
</select></label>
	</div>
	  
	
	 
	
	 
	
	 
	 
	 
	  
	
	 
	
	 
	
	 
	
	
	</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">
	
	
	
	
	
	
	
	
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
