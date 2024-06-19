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

$where1='id='.$id.' and userId='.$loginusersuperParentId.''; 

$rs1=GetPageRecord($select1,departmentMasters,$where1); 

$editresult=mysqli_fetch_array($rs1);



$department=clean($editresult['department']);

///$profileDetails=clean($editresult['profileDetails']);

$departmentId=clean($editresult['id']);





if($editresult['deletestatus']==1){

header('location:'.$fullurl.'');

exit();

} 



}







?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>
      <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td>Update Department</td>
    </tr>
</table>
	<?php } else { ?>
	Add Department
	<?php } ?>  </span></div></td>
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

<div id="pagelisterouter">
<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="<?php if(clean($_GET['id'])!=''){ echo 'editdepartment'; } else {  echo 'adddepartment'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td colspan="2" align="left" valign="top" ><div class="innerbox">

      <h2>Department Information</h2>

    </div></td>

    </tr>

  <tr>

    <td width="50%" align="left" valign="top" style="padding-right:20px;">

  
	<div class="griddiv">
	<label>
	<div class="gridlable">User Department <span class="redmind"></span></div>
	<input name="department" type="text" class="gridfield validate" id="department" value="<?php echo $department; ?>" maxlength="60" displayname="Department" autocomplete="off" />
	</label>
	</div>	 </td>
    </tr>
 <!--- <tr>
    <td colspan="2" align="left" valign="top" ></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">&nbsp;</td>
    <td width="50%" align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-bottom:10px;">Mail Body</td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" ><textarea name="mailbody" rows="16"  id="mailbody" style="width:100%;"><?php echo strip_tags($mailbody); ?></textarea></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>
  </tr>--->
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
comtabopenclose('linkbox','op2');
</script>







