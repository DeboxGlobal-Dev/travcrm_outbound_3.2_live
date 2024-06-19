<?php
if($viewpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}



if($_GET['id']!=''){
 $id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_ROLE_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$name=clean($editresult['name']);
$roleDetails=clean($editresult['roleDetails']);
$roleId=clean($editresult['id']); 
$roleparentId=$editresult['parentId']; 


$relatedroleid=$roleparentId;
}



 
$select1='*';  
$where1='id='.$relatedroleid.''; 
$rs1=GetPageRecord($select1,_ROLE_MASTER_,$where1); 
$relatedroleidname=mysqli_fetch_array($rs1);
 
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"> 
      <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="cancel();" style=" cursor:pointer;" /> </td>
    <td><?php echo $name; ?> </td>
    <td>&nbsp; </td>
  </tr>
</table>
	 </span></div></td>
    <td align="right"><?php if($id!=1){ ?><?php if($editpermission==1){ ?><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><a href="setupsetting.crm?module=role&edit=yes&sid=<?php echo encode($relatedroleidname['id']); ?>&id=<?php echo ($_GET['id']); ?>"><input type="button" name="Submit2" value="Edit" class="whitembutton"   /></a></td>
      </tr>
      
    </table><?php } ?><?php } ?></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
<form id="addeditfrm" name="addeditfrm" action="frm_action.crm" target="actoinfrm" method="post">
<div class="addeditpagebox">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="top" ><div class="innerbox">
      <h2>Role Information</h2>
    </div></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv">
	  <div class="gridlable">Role Name:</div> 
	  <div class="gridtext"><?php echo $name; ?></div>
	</label>
	</div><div class="griddiv">
	  <div class="gridlable">Reports To:</div> 
	  <div class="gridtext"><?php echo $relatedroleidname['name']; ?></div>
	</label>
	</div>	<div class="griddiv">
	  <div class="gridlable">Description:</div> 
	  <div class="gridtext"><?php echo $roleDetails; ?></div>
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
  <tr>
    <td align="left" valign="top" style="padding-right:20px;"><div class="innerbox">
      <h2>Associated Users</h2>
    </div></td>
    <td align="left" valign="top" style="padding-left:20px;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" ><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
   
     <th width="289" align="left" class="header" >Name</th>

     <th width="456" align="left" class="header">Email Address </th>

     <th width="361" align="center" class="header">User Status</th>
     </tr>
   </thead>

 


 

  <tbody>
  <?php 
$select='*';
$where='roleId='.$roleId.'  and superParentId='.$loginusersuperParentId.' order by id asc'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($usermaster=mysqli_fetch_array($rs)){
?>
  <tr>
    <td align="left" valign="top"><a href="setupsetting.crm?module=users&view=yes&id=<?php echo encode($usermaster['id']); ?>" target="_blank"><?php echo strip($usermaster['firstName']); ?> <?php echo strip($usermaster['lastName']); ?></a></td>

    <td align="left" valign="top"><a href="setupsetting.crm?module=users&view=yes&id=<?php echo encode($usermaster['id']); ?>" target="_blank"><?php echo strip($usermaster['email']); ?></a></td>

    <td align="center" valign="top"><?php if($usermaster['status']==1){ ?>
      <div class="statusactive">Active</div><?php } else { ?>
      <div class="statusdeactive">Inactive</div><?php } ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table></td>
    </tr>
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
