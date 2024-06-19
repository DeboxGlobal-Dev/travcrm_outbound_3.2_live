<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($deletepermission!=1 && $_GET['del']=='1'){
header('location:'.$fullurl.'');
}


if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}

if($_GET['sid']!=''){
$relatedroleid=decode(clean($_GET['sid']));  
}




if($_GET['id']!=''){
 $id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.' and userId='.$loginusersuperParentId.''; 
$rs1=GetPageRecord($select1,_ROLE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$name=clean($editresult['name']);
$roleDetails=clean($editresult['roleDetails']);
$roleId=clean($editresult['id']); 
$roleparentId=$editresult['parentId']; 


$relatedroleid=$roleparentId;
}



if($_GET['sid']!=''){
$select1='*';  
$where1='id='.$relatedroleid.''; 
$rs1=GetPageRecord($select1,_ROLE_MASTER_,$where1); 
$relatedroleidname=mysqli_fetch_array($rs1);
}

if($id==1){
header('location:'.$fullurl.'');
exit();
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>
      <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td><?php if($_GET['del']=='1'){ ?>Delete Role<?php } else { ?>Edit Role<?php  }?> </td>
    <td>&nbsp; </td>
  </tr>
</table>
	<?php } else { ?>Add Role <?php } ?>  </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($profileId!=1){ ?><?php if($_REQUEST['del']!=1){ ?><td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td><?php } } ?>
		
		<?php if($_REQUEST['del']==1){ ?><td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Transfer and Delete" onclick="formValidation('addeditfrm','submitbtn','0');" /></td><?php  } ?>
		
		
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
  <?php if($_GET['del']!=1){ ?>
   <input name="action" type="hidden" id="action" value="<?php if(clean($_GET['id'])!=''){ echo 'editrole'; } else {  echo 'addrole'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <input name="roleId" type="hidden" id="roleId" value="<?php echo $relatedroleidname['id']; ?>" />
  
  
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Role Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv">
	<label>
	<div class="gridlable">Role Name <span class="redmind"></span></div>
	<input name="name" type="text" class="gridfield validate" id="name" value="<?php echo $name; ?>" maxlength="60" displayname="Role Name" autocomplete="off" />
	</label>
	</div><div class="griddiv"  onclick="alertspopupopen('action=selectrole','600px','auto');"><img src="images/userrole.png" style="position:absolute; right:4px; top:26px; cursor:pointer;" />
	<label>
	<div class="gridlable">Reports To  <span class="redmind"></span></div>
	<input name="roleidname" type="text" class="gridfield validate" id="roleidname" maxlength="60" displayname="Reports To" autocomplete="off" readonly="true" style=" cursor:pointer;" value="<?php echo $relatedroleidname['name']; ?>" />
	</label>
	</div>	<div class="griddiv">
      <label>
      <div class="gridlable">Role Description </div>
      <input name="roleDetails" type="text" class="gridfield" id="roleDetails" value="<?php echo $roleDetails; ?>" maxlength="230"  autocomplete="off" />
      </label>
    </div></td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;"> </td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" ></td>
    </tr>
  <tr>
    <td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
  </tr>
  
  <?php } else { ?>
  <tr>
    <td colspan="2" align="left" valign="top" ><h2>Transfer Users and Sub-roles:</h2></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  >Before deleting, you must transfer users and subordinates with this role to a new role.</td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;"><div class="griddiv">
	<label>
	<div class="gridlable">Role to be Deleted  </div>
	<input name="ROlename" type="text" class="gridfield validate" id="ROlename" value="<?php echo $relatedroleidname['name']; ?>" maxlength="60" displayname="Role Name" autocomplete="off" readonly="true" />
	</label>
	<input name="roledid" type="hidden" id="roledid" value="<?php echo clean($_GET['id']); ?>" /></div>
	
	<div class="griddiv"  onclick="alertspopupopen('action=selectrole&notid=<?php echo clean($_GET['id']); ?>','600px','auto');"><img src="images/userrole.png" style="position:absolute; right:0px; cursor:pointer;" />
	<label>
	<div class="gridlable">Transfer to Role  <span class="redmind"></span></div>
	<input name="roleidname" type="text" class="gridfield validate" id="roleidname" maxlength="60" displayname="Transfer to Role" autocomplete="off" readonly="true" style=" cursor:pointer;" value="" />
	</label>
	<input name="action" type="hidden" id="action" value="deleterole" /></div>
	</td>
    <td width="50%" align="left" valign="top" >&nbsp;</td>
  </tr>
  
  <?php } ?>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
  </tr>
</table>
 

</div>
 
</form>
 
</div>
<script>  
comtabopenclose('linkbox','op2');
</script>
