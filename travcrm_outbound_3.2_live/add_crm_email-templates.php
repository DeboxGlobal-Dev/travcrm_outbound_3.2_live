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
$rs1=GetPageRecord($select1,_EMAIL_TEMPLATE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$subject=clean($editresult['subject']);
$mailbody=stripslashes($editresult['mailbody']);
$isDefault=stripslashes($editresult['isDefault']);
$profileId=clean($editresult['id']); 


if($editresult['deletestatus']==1){
header('location:'.$fullurl.'');
exit();
}


}


?>

<script src="tinymce/tinymce.min.js"></script>
  
<script type="text/javascript">

    tinymce.init({

        selector: "#mailbody",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>
      <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td>Update Email Template</td>
    </tr>
</table>
	<?php } else { ?>Add Email Template
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
  <input name="action" type="hidden" id="action" value="<?php if(clean($_GET['id'])!=''){ echo 'editemailtemplate'; } else {  echo 'addmailtemplate'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" > </td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top"  >
	<div class="griddiv">
	<label>
	<div class="gridlable">Mail Subject <span class="redmind"></span></div>
	<input name="subject" type="text" class="gridfield validate" id="subject" value="<?php echo $subject; ?>" maxlength="60" displayname="Mail Subject" autocomplete="off" />
	</label>
	</div>	 </td>
    </tr>
  <tr>
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
    <td colspan="2" align="left" valign="top" ><textarea name="mailbody" rows="16"  id="mailbody" style="width:100%;"><?php echo strip($mailbody); ?></textarea></td>
    </tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;">
      <div class="griddiv">
        <label>
          <!-- <div class="gridlable">Default</div> --><br>
          <input name="isDefault" type="checkbox" style="display: inline-block;" id="isDefault" value="1" <?php if($isDefault=='1'){ ?>checked="checked"<?php } ?>/>&nbsp;&nbsp;Set Default
        </label>
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
