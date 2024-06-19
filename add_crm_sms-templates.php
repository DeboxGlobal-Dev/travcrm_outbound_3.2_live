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
$rs1=GetPageRecord($select1,_SMS_TEMPLATE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$smsbody=clean($editresult['smsbody']); 
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
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>
      <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td>Update SMS Template</td>
    </tr>
</table>
	<?php } else { ?>
	Add SMS Template
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
  <input name="action" type="hidden" id="action" value="<?php if(clean($_GET['id'])!=''){ echo 'editsmstemplate'; } else {  echo 'addsmstemplate'; } ?>" />
  <input name="savenew" type="hidden" id="savenew" value="0" />
  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" align="left" valign="top" > </td>
    </tr>
  <tr>
    <td align="left" valign="top"  >
	<div class="griddiv">
	<label>
	<div class="gridlable">SMS Body <span style="font-size:12px;">(supporting 160 character only.)</span> <span class="redmind"></span></div>
	<textarea name="smsbody" rows="3" class="gridfield validate" id="smsbody" displayname="SMS Body" autocomplete="off"><?php echo $smsbody; ?></textarea>
	</label>
	</div>	 </td>
    </tr>
  <tr>
    <td align="left" valign="top" ></td>
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
