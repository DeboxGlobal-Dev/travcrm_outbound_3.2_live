<?php
if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}


if($_GET['id']!=''){
 $id=clean(decode($_GET['id']));

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_USER_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$editUserId=clean($editresult['id']);
$editComapnyanme=clean($editresult['company']); 

}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:10px;"><img src="images/backicon.png" width="20" onclick="view('<?php echo $_REQUEST['id']; ?>');" style=" cursor:pointer;" /> </td>
    <td><?php echo $editComapnyanme; ?></td>
  </tr>
  
</table>
        <input type="hidden" name="id"  id="id" value="<?php echo $_GET['id']; ?>"/>
    </div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="view('<?php echo $_REQUEST['id']; ?>');" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
 <div class="addeditpagebox vieweditpagebox"><div class="innerbox"><h2>Administrator Permissions</h2>
 <?php
 $n=1;
$select='*';
$where=' id in (select parentId from '._USER_MODULE_MASTER_.' where userId='.$editUserId.') order by sr asc'; 
$rs=GetPageRecord($select,_MODULE_MASTER_,$where); 
while($modulelists=mysqli_fetch_array($rs)){

$select1='*';
$where1='parentId='.$modulelists['id'].' and userId='.$editUserId.''; 
$rs1=GetPageRecord($select1,_USER_MODULE_MASTER_,$where1); 
$usermodule=mysqli_fetch_array($rs1);

 
?>
 <div class="griddiv">
	  <div class="gridlable" style="width:25%;"><?php echo $modulelists['moduleName']; ?></div> 
	<div class="gridtext"><div id="c<?php echo $n; ?>" onclick="permissiononoff('c<?php echo $n; ?>','<?php echo encode($usermodule['id']); ?>');" class="switchouter <?php if($usermodule['status']==1){ ?>switchouteron<?php } else { ?>switchouteroff<?php } ?>"></div>
	
	
	
	<div class="permissiontext"><?php if($usermodule['parentId']==1){ ?>View<?php } ?><?php if($usermodule['parentId']!=1){ ?>View, Add, Edit, Delete <?php if($modulelists['sr']<22){ ?>,Import, Export<?php } ?><?php } ?></div></div>
	</label>
	</div>
 <?php $n++;} ?>
 </div>
   </div>

  
 
</div>
<script>  
comtabopenclose('linkbox','op4');
</script>
