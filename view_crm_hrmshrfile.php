<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
$id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_HRMS_FILE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);
$editname=clean($editresult['name']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyDate=clean($editresult['modifyDate']);
$editdocumentCategory=clean($editresult['documentCategory']);
$editdesignation=clean($editresult['designation']);
$editemployee=clean($editresult['employee']);
$editpermissionView=clean($editresult['permissionView']);
$editdocumentCategory=clean($editresult['documentCategory']);


$editsupId=clean($editresult['id']);
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
    <td style="padding-right:10px;"><!--<img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" />--><img src="images/backicon.png" width="20" onclick="goBack()" style=" cursor:pointer;" /> </td>
    <td><?php echo $editname; ?></td>
  </tr>
  
</table>
</div></td>
    <!--<td align="right"><?php if($editpermission==1){ ?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Edit" class="whitembutton" onclick="edit('<?php echo $_GET['id']; ?>');" /></td>
      </tr>
      
    </table><?php } ?></td>-->
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">

 <div class="addeditpagebox vieweditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox"><h2>HR File Information</h2></div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	
	<div class="griddiv"><label><div class="gridlable">Name</div>
	<div class="gridtext"><?php echo $editname; ?></div>
	 
	</label>
	</div>
	<div class="griddiv"><label><div class="gridlable">Category</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editdocumentCategory.'';  
$rs=GetPageRecord($select,_DOCUMENT_CATEGORY_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	
	 </div>
	</label>
	</div> 
	
	<?php if($editpermissionView == 1){?>
	<div class="griddiv"><label><div class="gridlable">Designation</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editdesignation.'';  
$rs=GetPageRecord($select,_ROLE_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	
	 </div>
	</label>
	</div> 
	<?php } ?>
	
	<?php if($editpermissionView == 0){?>
	<div class="griddiv"><label><div class="gridlable">Employee</div>
	<div class="gridtext">
<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='id='.$editemployee.'';  
$rs=GetPageRecord($select,_EMPLOYEE_MANAGEMENT_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  
 echo strip($resListing['name']);   }
?>
	
	 </div>
	</label>
	</div> 
	<?php } ?>
	
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
	<td width="50%" align="left" valign="top" style="padding-right:20px;">
	</td>
	</tr>
  <tr>
    <td colspan="2" align="left" valign="top" style="padding-right:20px;">
	 <h2 style="margin-bottom:10px;">Upload Document</h2>
	<div style="background-color:#f8f8f8; padding:20px; overflow:hidden; margin-bottom:30px;">
	<script>
	function removepicture(id){
	$('#actiondiv').load('hrfrmaction.php?action=removepicture&&module=<?php echo $_GET['module']; ?>&&parentId=<?php echo $id; ?>&did='+id);
	}
	</script>
	<?php 
$g=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' parentId='.$id.' order by id desc';  
$rs=GetPageRecord($select,_HRMS_DOCUMENT_MASTER_,$where); 
while($gallery=mysqli_fetch_array($rs)){  

?>
<div style="background-color:#FFFFFF;  border-radius: 5px; padding:0px; float:left; margin:10px; overflow:hidden; width:150px; height:90px; position:relative;"><a href="dirfiles/hrms_files/<?php echo $gallery['name']; ?>" style="width:100%;" / target="Blank_"><?php echo $gallery['name']; ?></a>
<a style="color:#FF0000 !important;  font-size:12px;" onclick="if(confirm('Are you sure you want delete this document?')) removepicture('<?php echo $gallery['id']; ?>');">
<div style="width: 20px;height: 20px;background-color:#FFFFFF;position:absolute;right:2px;bottom:2px;padding: 4px;border-radius: 5px; text-align: center; cursor:pointer;"><i class="fa fa-trash" style="font-size: 18px;color:#FF0000;"></i></div></a>
</div>

 
<?php $g++;} ?>



<?php if($g==1){ ?>

<div style="background-color:#FFFFFF; padding:20px; text-align:center; font-size:15px;">No Document Uploaded<div style="text-align:center; margin-top:10px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Upload Document" style=" background-color:#45b558 !important; border:#45b558 1px solid !important; margin-left:0px;" onclick="uploaddocument();"></div></div>

<?php } else { ?>
<div style="background-color:#45b558;  color:#fff; cursor:pointer; border-radius: 5px; text-align:center; padding:0px; float:left; margin:10px; overflow:hidden; width:150px; height:90px;" onclick="uploaddocument();"><i class="fa fa-fw fa-plus" style="font-size:55px; margin-top:21px;"></i></div>
<?php } ?>

 <form action="hr_frm_action.crm" method="post" enctype="multipart/form-data" name="imageaddeditfrm" target="actoinfrm" id="imageaddeditfrm" style="display:none;">
 <input name="documentname" id="documentname" type="file" accept="application/msword, application/vnd.ms-excel,text/plain, application/pdf" onchange="$('#imageaddeditfrm').submit();$('#pageloader').hide();$('#pageloading').hide();" />
 <input name="action" id="action" type="hidden" value="uploaddocument" />
 <input name="parentId" id="parentId" type="hidden" value="<?php echo $id; ?>" />
 <input name="module" id="module" type="hidden" value="<?php echo $_GET['module']; ?>" />
 </form>
<script>
function uploaddocument(){
$('#documentname').trigger('click'); 
}
</script>	
	
	</div></td>
  </tr>
</table>
</div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op2');
</script>
