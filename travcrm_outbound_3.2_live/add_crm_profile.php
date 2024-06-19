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

$rs1=GetPageRecord($select1,_PROFILE_MASTER_,$where1); 

$editresult=mysqli_fetch_array($rs1);



$profileName=clean($editresult['profileName']);

$profileDetails=clean($editresult['profileDetails']);

$profileId=clean($editresult['id']);





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

    <td><?php echo $profileName; ?>'s</td>

    <td> &nbsp;Profile</td>

  </tr>

</table>

	<?php } else { ?>Add Profile<?php } ?>  </span></div></td>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td>        </td>

        <?php if($profileId!=1){ ?><td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td><?php } ?>

         <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>

      </tr>

      

    </table></td>

  </tr>

  

</table>

</div>



<div id="pagelisterouter">

<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">

<div class="addeditpagebox">

  <input name="action" type="hidden" id="action" value="<?php if(clean($_GET['id'])!=''){ echo 'editprofile'; } else {  echo 'addprofile'; } ?>" />

  <input name="savenew" type="hidden" id="savenew" value="0" />

  <input name="editid" type="hidden" id="editid" value="<?php echo clean($_GET['id']); ?>" />

  <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td colspan="2" align="left" valign="top" ><div class="innerbox">

      <h2>Profile Information</h2>

    </div></td>

    </tr>

  <tr>

    <td width="50%" align="left" valign="top" style="padding-right:20px;">

	<div class="griddiv">

	<label>

	<div class="gridlable">Profile Name <span class="redmind"></span></div>

	<input name="profileName" type="text" class="gridfield validate" id="profileName" value="<?php echo $profileName; ?>" maxlength="60" displayname="Profile Name" autocomplete="off" />

	</label>

	</div>	<div class="griddiv">

      <label>

      <div class="gridlable">Profile Description </div>

      <input name="profileDetails" type="text" class="gridfield" id="profileDetails" value="<?php echo $profileDetails; ?>" maxlength="230"  autocomplete="off" />

      </label>

    </div> 
	 
	<div class="griddiv">
	<div class="gridlable">Permission  <span class="redmind"></span></div>
	<div style="border:1px #e0e0e0 solid; margin-top:5px; background-color:#FFFFFF; padding:2px;" id="suppservice" ><table width="100%" border="0" cellpadding="5" cellspacing="0">
     
  <tr>
    <td colspan="2"><label><input name="adminDashboard" type="checkbox" id="adminDashboard" style="display: block;" value="1"  <?php if($editresult['adminDashboard']==1){ ?>checked="checked" <?php } ?> />
    </label></td>
    <td width="96%"><label for="adminDashboard">Admin Dashboard</label></td>
  </tr> 
   
    <tr>
    <td colspan="2"><label><input name="salesDashboard" type="checkbox" id="salesDashboard" style="display: block;" value="1"  <?php if($editresult['salesDashboard']==1){ ?>checked="checked" <?php } ?> />
    </label></td>
    <td width="96%"><label for="salesDashboard">Sales Dashboard</label></td>
  </tr> 
   
   <tr>
    <td colspan="2"><label><input name="operationsDashboard" type="checkbox" id="operationsDashboard" style="display: block;" value="1"  <?php if($editresult['operationsDashboard']==1){ ?>checked="checked" <?php } ?> />
    </label></td>
    <td width="96%"><label for="operationsDashboard">Operations Dashboard</label></td>
  </tr>
  
  
  <tr>
    <td colspan="2"><label><input name="accountDashboard" type="checkbox" id="accountDashboard" style="display: block;" value="1"  <?php if($editresult['accountDashboard']==1){ ?>checked="checked" <?php } ?> />
    </label></td>
    <td width="96%"><label for="accountDashboard">Accounts Dashboard</label></td>
  </tr>
   
  <tr>
    <td colspan="2"><label><input name="agentOption" type="checkbox" id="agentOption" style="display: block;" value="1"  <?php if($editresult['agentOption']==1){ ?>checked="checked" <?php } ?> />
    </label></td>
    <td width="96%"><label for="agentOption">Agent Create Query</label></td>
  </tr>
     
  </table>
</div>
	</div> 
	 </td>

    <td width="50%" align="left" valign="top" style="padding-left:20px;"><?php if(clean($_GET['id'])==''){ ?><div class="griddiv">

	<label>

	<div class="gridlable">Clone Profile  <span class="redmind"></span></div>

	<select id="profileclone" name="profileclone" class="gridfield">

 <?php 

$select=''; 

$where=''; 

$rs='';  

$select='profileName,id,deletestatus';   

$where='userId='.$loginusersuperParentId.' or (userId=0)  order by id asc'; 

$rs=GetPageRecord($select,_PROFILE_MASTER_,$where); 

while($timeformat=mysqli_fetch_array($rs)){  

if($timeformat['deletestatus']!=1){

?>

<option value="<?php echo encode($timeformat['id']); ?>" <?php if($timeformat['id']==$editTimeformat){ ?>selected="selected"<?php } ?>><?php echo strip($timeformat['profileName']); ?></option>

<?php } } ?>

</select>

	</label>

	</div><?php } ?> </td>

  </tr>

  <tr>

    <td colspan="2" align="left" valign="top" ></td>

    </tr>

  <tr>

    <td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>

    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>

  </tr>

  <tr>

    <td align="left" valign="top" style="padding-right:20px;">&nbsp;</td>

    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>

  </tr>

  <tr>

    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>

    </tr>

  <tr>

    <td colspan="2" align="left" valign="top" style="padding-right:20px;"></td>

  </tr>

</table>

<?php if($profileId!=''){ ?>

<div class="innerbox">

      <h2>Permissions</h2>

    </div>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">



   <thead>



   <tr>

     <th align="left" class="header" >&nbsp;</th>

	 <th align="left" class="header">&nbsp;</th>
	 <style>

	 .fa-spin{font-size:24px;}

	 </style>

		<script>

		$(document).on('click', '#viewselectall', function(event) { 

    event.preventDefault(); 

    $(".selectviewall").click(); 

	$('#viewselectall').html('<i class="fa fa-cog fa-spin"></i>');

	setTimeout(function(){ 

	window.location.href = 'setupsetting.crm?module=profile&edit=yes&id=<?php echo $_REQUEST['id']; ?>';

	 },12000);

});





$(document).on('click', '#addviewselectall', function(event) { 

    event.preventDefault(); 

    $(".selectaddall").click(); 

	$('#addviewselectall').html('<i class="fa fa-cog fa-spin"></i>');

	setTimeout(function(){ 

	window.location.href = 'setupsetting.crm?module=profile&edit=yes&id=<?php echo $_REQUEST['id']; ?>';

	 },12000);

});



$(document).on('click', '#addeditselectall', function(event) { 

    event.preventDefault(); 

    $(".selecteditall").click(); 

	$('#addeditselectall').html('<i class="fa fa-cog fa-spin"></i>');

	setTimeout(function(){ 

	window.location.href = 'setupsetting.crm?module=profile&edit=yes&id=<?php echo $_REQUEST['id']; ?>';

	 },12000);

});



$(document).on('click', '#adddeleteselectall', function(event) { 

    event.preventDefault(); 

    $(".selectdeleteall").click(); 

	$('#adddeleteselectall').html('<i class="fa fa-cog fa-spin"></i>');

	setTimeout(function(){ 

	window.location.href = 'setupsetting.crm?module=profile&edit=yes&id=<?php echo $_REQUEST['id']; ?>';

	 },12000);

});







$(document).on('click', '#addimportselectall', function(event) { 

    event.preventDefault(); 

    $(".selectimporteall").click(); 

	$('#addimportselectall').html('<i class="fa fa-cog fa-spin"></i>');

	setTimeout(function(){ 

	window.location.href = 'setupsetting.crm?module=profile&edit=yes&id=<?php echo $_REQUEST['id']; ?>';

	 },12000);

});







$(document).on('click', '#addexportselectall', function(event) { 

    event.preventDefault(); 

    $(".selectexporteall").click(); 

	$('#addexportselectall').html('<i class="fa fa-cog fa-spin"></i>');

	setTimeout(function(){ 

	window.location.href = 'setupsetting.crm?module=profile&edit=yes&id=<?php echo $_REQUEST['id']; ?>';

	 },12000);

});



		</script>

		

     <th align="left" class="header"><a href="#" id="viewselectall">Select All</a> </th>

     <th align="left" class="header"><a href="#" id="addviewselectall">Select All</a> </th>

     <th align="left" class="header"><a href="#" id="addeditselectall">Select All</a></th>

     <th align="left" class="header"><a href="#" id="adddeleteselectall">Select All</a></th>

     <th align="left" class="header" ><a href="#" id="addimportselectall">Select All</a></th>

     <th align="left" class="header" ><a href="#" id="addexportselectall">Select All</a></th>

     <th align="left" class="header"  >&nbsp;</th>
   </tr>

   <tr>

    

     <th width="30%" align="left" class="header" >module</th>



     <th width="10%" align="left" class="header">&nbsp;</th>
     <th width="10%" align="left" class="header">View</th>

     <th width="10%" align="left" class="header">Add</th>



     <th width="10%" align="left" class="header">Edit</th>

     <th width="10%" align="left" class="header">Delete</th>

     <th width="10%" align="left" class="header" >Import</th>

     <th width="10%" align="left" class="header" >Export</th>

     <th width="30" align="left" class="header"  >&nbsp;</th>
    </tr>
   </thead>



 





 



  <tbody>

  <?php

 $n=1;

$select='*';

$where=' id in ( select parentId from '._USER_MODULE_MASTER_.' where status=1 and userId='.$loginusersuperParentId.' ) and sr !=100 order by sr asc'; 

$rs=GetPageRecord($select,_MODULE_MASTER_,$where ); 

while($modulelist=mysqli_fetch_array($rs)){





$selecta='*';  

$wherea='moduleId='.$modulelist['id'].' and profileId='.$profileId.''; 

$rsa=GetPageRecord($selecta,_PERMISSION_MASTER_,$wherea); 

$permissionlist=mysqli_fetch_array($rsa);

?>

  <tr>

    



  

    <td width="30%" align="left" valign="top"><?php echo $modulelist['moduleName']; ?></td>



    <td width="10%" align="left" valign="top"><a style="cursor:pointer;"  onclick="userpermissiononoff('v<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','view');userpermissiononoff('a<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','addentry');userpermissiononoff('e<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','edit');userpermissiononoff('d<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','dlt');userpermissiononoff('i<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','import');userpermissiononoff('ex<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','export');"><strong style="font-weight:500;">Select All</strong></a></td>
    <td width="10%" align="left" valign="top"><div id="v<?php echo $n; ?>" onclick="userpermissiononoff('v<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','view');" class="selectviewall switchouter <?php if($permissionlist['view']==1){ ?>switchouteron<?php } else { ?>switchouteroff<?php } ?>"></div></td>

    <td width="10%" align="left" valign="top"><div id="a<?php echo $n; ?>" onclick="userpermissiononoff('a<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','addentry');" class="selectaddall switchouter <?php if($permissionlist['addentry']==1){ ?>switchouteron<?php } else { ?>switchouteroff<?php } ?>"></div></td>



    <td width="10%" align="left" valign="top"><div id="e<?php echo $n; ?>" onclick="userpermissiononoff('e<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','edit');" class="selecteditall switchouter <?php if($permissionlist['edit']==1){ ?>switchouteron<?php } else { ?>switchouteroff<?php } ?>"></div></td>

    <td width="10%" align="left" valign="top"><div id="d<?php echo $n; ?>" onclick="userpermissiononoff('d<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','dlt');" class="selectdeleteall switchouter <?php if($permissionlist['dlt']==1){ ?>switchouteron<?php } else { ?>switchouteroff<?php } ?>"></div></td>

    <td width="10%" align="left" valign="top"style="width:50px;"><div id="i<?php echo $n; ?>" onclick="userpermissiononoff('i<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','import');" class="selectimporteall switchouter <?php if($permissionlist['import']==1){ ?>switchouteron<?php } else { ?>switchouteroff<?php } ?>"></div></td>

    <td width="10%" align="left" valign="top"style="width:50px;"><div id="ex<?php echo $n; ?>" onclick="userpermissiononoff('ex<?php echo $n; ?>','<?php echo encode($modulelist['id']); ?>','export');" class="selectexporteall switchouter <?php if($permissionlist['export']==1){ ?>switchouteron<?php } else { ?>switchouteroff<?php } ?>"></div></td>

    <td width="30" align="left" valign="top"style="width:50px;">&nbsp;</td>
    </tr> 

	

	<?php $n++; } ?>
</tbody></table>

	

	<?php } ?>



</div>

<?php if($_GET['id']==''){ ?>

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

<?php } ?>

</form>

 

</div>

<script>  

comtabopenclose('linkbox','op2');

</script>

